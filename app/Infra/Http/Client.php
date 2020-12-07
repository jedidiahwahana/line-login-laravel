<?php

namespace App\Infra\Http;

use Illuminate\Support\Facades\Log;

class Client
{
  public function httpPost($url, $header, $params)
  {
    $postData = '';
    //create name value pairs seperated by &
    foreach($params as $k => $v)
    {
      $postData .= $k . '='.$v.'&';
    }
    $postData = rtrim($postData, '&');

    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, $header);
    //curl_setopt($ch, CURLOPT_POST, count($postData)); BUG error count($postData)
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $output=curl_exec($ch);
    curl_close($ch);
    return $output;
  }

  public function httpGet($url, $header)
  {
    $ch = curl_init();

    Log::info("Client.httpGet: " . $url);
    Log::info("Client.httpGet: " . $header);

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array($header));

    $output=curl_exec($ch);
    curl_close($ch);
    return $output;
  }
}
