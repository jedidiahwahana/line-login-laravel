<?php

namespace App\Infra\Line\API\v2;

use Illuminate\Support\Facades\Log;

class LineAPI {

  public function accessToken($code, $channelId, $channelSecret, $callback_url){
    return array(
      'Url' => 'https://api.line.me/v2/oauth/accessToken',
      'Method' => 'post',
      'Header' => 'Content-Type: application/x-www-form-urlencoded',
      'Body' => array(
            'grant_type'=>'authorization_code',
            'code'=>$code,
            'client_id'=>$channelId,
            'client_secret'=>$channelSecret,
            'redirect_uri'=>$callback_url
    ));
  }

  public function refreshToken($refresh_token, $channelId, $channelSecret){
    return array(
      'Url' => 'https://api.line.me/v2/oauth/accessToken',
      'Method' => 'post',
      'Header' => 'Content-Type: application/x-www-form-urlencoded',
      'Body' => array(
            urlencode('grant_type')=>urlencode('refresh_token'),
            urlencode('refresh_token')=>urlencode($refresh_token),
            urlencode('client_id')=>urlencode($channelId),
            urlencode('client_secret')=>urlencode($channelSecret)
    ));
  }

  public function verify($access_token){
    return array(
      'Url' => 'https://api.line.me/v2/oauth/verify',
      'Method' => 'post',
      'Header' => 'Content-Type: application/x-www-form-urlencoded',
      'Body' => array(
            urlencode('access_token')=>urlencode($access_token)
    ));
  }

  public function revoke($refresh_token){
    return array(
      'Url' => 'https://api.line.me/v2/oauth/revoke',
      'Method' => 'post',
      'Header' => 'Content-Type: application/x-www-form-urlencoded',
      'Body' => array(
            urlencode('access_token')=>urlencode($refresh_token)
    ));
  }

  public function profile($bearer){
    return array(
      'Url' => 'https://api.line.me/v2/profile',
      'Method' => 'get',
      'Header' => 'Authorization: ' . $bearer
    );
  }
}
