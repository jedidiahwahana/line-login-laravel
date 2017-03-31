<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Infra\Utils\CommonUtils;
use App\Infra\Line\API\v2\LineAPIService;
use App\Infra\Line\API\v2\Response\AccessToken;
use App\Infra\Line\API\v2\Response\Profile;

class WebController extends Controller
{
    public function login(){
      return view('login');
    }

    public function goToAuthPage(Request $request){
      $commonUtils = new CommonUtils;
      $state = $commonUtils->getToken();
      $request->session()->put('LINE_WEB_LOGIN_STATE', $state);
      $lineAPIService = new LineAPIService;
      $url = $lineAPIService->getLineWebLoginUrl($state);
      return redirect($url);
    }

    public function auth(Request $request){
      $code = $request->input('code');
      $state = $request->input('state');
      $scope = $request->input('scope');
      $error = $request->input('error');
      $errorCode = $request->input('errorCode');
      $errorMessage = $request->input('errorMessage');

      Log::debug('parameter code: ' . $code);
      Log::debug('parameter state: ' . $state);
      Log::debug('parameter scope: ' . $scope);
      Log::debug('parameter error: ' . $error);
      Log::debug('parameter errorCode: ' . $errorCode);
      Log::debug('parameter errorMessage: ' . $errorMessage);

      if (is_null($code) || !is_null($errorCode) || !is_null($errorMessage)){
        return redirect('loginCancel');
      }

      if (!($state == $request->session()->get('LINE_WEB_LOGIN_STATE'))){
        return redirect('sessionError');
      }

      $request->session()->forget('line_state');
      $lineAPIService = new LineAPIService;
      $token = new AccessToken($lineAPIService->accessToken($code));
      Log::debug('parameter scope: ' . $token->scope);
      Log::debug('parameter access_token: ' . $token->access_token);
      Log::debug('parameter token_type: ' . $token->token_type);
      Log::debug('parameter expires_in: ' . $token->expires_in);
      Log::debug('parameter refresh_token: ' . $token->refresh_token);
      $request->session()->put('ACCESS_TOKEN', $token->access_token);
      $request->session()->put('REFRESH_TOKEN', $token->refresh_token);

      return redirect('success');
    }

    public function success(Request $request){
      $token = $request->session()->get('ACCESS_TOKEN');
      if (is_null($token)){
        return redirect('/');
      }
      $lineAPIService = new LineAPIService;
      $profile = new Profile($lineAPIService->profile($token));
      Log::debug('parameter userId: ' . $profile->userId);
      Log::debug('parameter displayName: ' . $profile->displayName);
      Log::debug('parameter pictureUrl: ' . $profile->pictureUrl);
      Log::debug('parameter statusMessage: ' . $profile->statusMessage);
      return view('success')->with([
        'displayName' => $profile->displayName,
        'pictureUrl' => $profile->pictureUrl,
        'statusMessage' => $profile->statusMessage
      ]);
    }

    public function loginCancel(){
      return view('login_cancel');
    }

    public function sessionError(){
      return view('session_error');
    }
}
