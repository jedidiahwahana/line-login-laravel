<?php

namespace App\Infra\Line\API\v2\Response;

class AccessToken
{
    var $scope;
    var $access_token;
    var $token_type;
    var $expires_in;
    var $refresh_token;

    public function __construct(array $data){
      $this->scope = $data[0];
      $this->access_token = $data[1];
      $this->token_type = $data[2];
      $this->expires_in = $data[3];
      $this->refresh_token = $data[4];
    }

    public function scope(){
      return $this->scope;
    }

    public function access_token(){
      return $this->access_token;
    }

    public function token_type(){
      return $this->token_type;
    }

    public function expires_in(){
      return $this->expires_in;
    }

    public function refresh_token(){
      return $this->refresh_token;
    }
}
