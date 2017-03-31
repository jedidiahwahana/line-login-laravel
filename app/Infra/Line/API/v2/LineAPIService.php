<?php

namespace App\Infra\Line\API\v2;

use App\Infra\Http\Client;
use App\Infra\Line\API\v2\Response\AccessToken;
use App\Infra\Line\API\v2\Response\Profile;
use App\Infra\Line\API\v2\Response\Verify;

use Illuminate\Support\Facades\Log;

class LineAPIService {

    public function accessToken($code){
      $lineAPI = new LineAPI;
      $json_result = json_decode(self::getClient($lineAPI->accessToken($code, getenv('LINE_CHANNEL_ID'), getenv('LINE_CHANNEL_SECRET'), getenv('LINE_CALLBACK_URL'))), true);
      return array(
        $json_result['scope'],
        $json_result['access_token'],
        $json_result['token_type'],
        $json_result['expires_in'],
        $json_result['refresh_token']);
    }

    public function refreshToken($refresh_token){
      $lineAPI = new LineAPI;
      $json_result = json_decode(self::getClient($lineAPI->refreshToken($refresh_token, getenv('LINE_CHANNEL_ID'), getenv('LINE_CHANNEL_SECRET'))), true);
      return array(
        $json_result['scope'],
        $json_result['access_token'],
        $json_result['token_type'],
        $json_result['expires_in'],
        $json_result['refresh_token']);
    }

    public function verify($accessToken){
      $lineAPI = new LineAPI;
      $json_result = json_decode(self::getClient($lineAPI->verify($accessToken)), true);
      return array(
        $json_result['scope'],
        $json_result['client_id'],
        $json_result['expires_in']);
      }

    public function revoke($refresh_token){
      $lineAPI = new LineAPI;
      $json_result = json_decode(self::getClient($lineAPI->revoke($refresh_token)), true);
      return "Ok";
    }

    public function profile($accessToken){
      $lineAPI = new LineAPI;
      $json_result = json_decode(self::getClient($lineAPI->profile(self::addBearer($accessToken))), true);
      if (!array_key_exists('statusMessage', $json_result)){
        $json_result['statusMessage'] = " ";
      }
      return array(
        $json_result['displayName'],
        $json_result['userId'],
        $json_result['pictureUrl'],
        $json_result['statusMessage']);
    }

    public static function getLineWebLoginUrl($state) {
        $encodedCallbackUrl = urlencode(getenv('LINE_CALLBACK_URL'));
        return "https://access.line.me/dialog/oauth/weblogin?response_type=code" . "&client_id=" . getenv('LINE_CHANNEL_ID') . "&redirect_uri=" . $encodedCallbackUrl . "&state=" . $state;
    }

    private function getClient($data){
      Log::info("LineAPIService.getClient: " . json_encode($data));
      $client = new Client;
      if ($data['Method'] == 'post'){
        $output = $client->httpPost($data['Url'], $data['Header'], $data['Body']);
      } elseif ($data['Method'] == 'get') {
        $output = $client->httpGet($data['Url'], $data['Header']);
      }
      Log::info("LineAPIService.getClient: " . $output);
      return $output;
    }

    private function addBearer($accessToken){
      return "Bearer " . $accessToken;
    }
}
