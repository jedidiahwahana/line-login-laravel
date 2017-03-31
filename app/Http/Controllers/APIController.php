<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Infra\Line\API\v2\Response\AccessToken;
use App\Infra\Line\API\v2\LineAPIService;

class APIController extends Controller
{
    public function refreshToken(Request $request){
      Log::debug('refreshToken start');
      $token = self::getRefreshToken($request);
      $lineAPIService = new LineAPIService;
      $newAccessToken = new AccessToken($lineAPIService->refreshToken($token));
      if (!(is_null($newAccessToken->access_token))){
        Log::debug('parameter scope: ' . $newAccessToken->scope);
        Log::debug('parameter access_token: ' . $newAccessToken->access_token);
        Log::debug('parameter token_type: ' . $newAccessToken->token_type);
        Log::debug('parameter expires_in: ' . $newAccessToken->expires_in);
        Log::debug('parameter refresh_token: ' . $newAccessToken->refresh_token);
        self::setAccessToken($request, $newAccessToken->access_token);
        self::setRefreshToken($request, $newAccessToken->refresh_token);
      }
      return $newAccessToken->scope;
    }

    public function verify(Request $request){
      $token = self::getAccessToken($request);
      $lineAPIService = new LineAPIService;
      return $lineAPIService->verify($token);
    }

    public function revoke(Request $request){
      $token = self::getRefreshToken($request);
      $lineAPIService = new LineAPIService;
      return $lineAPIService->revoke($token);
    }

    private function getAccessToken(Request $request){
      return $request->session()->get('ACCESS_TOKEN');
    }

    private function setAccessToken(Request $request, $accessToken){
      $request->session()->put('ACCESS_TOKEN', $accessToken);
    }

    private function getRefreshToken(Request $request){
      return $request->session()->get('REFRESH_TOKEN');
    }

    private function setRefreshToken(Request $request, $refreshToken){
      $request->session()->put('REFRESH_TOKEN', $refreshToken);
    }
}
