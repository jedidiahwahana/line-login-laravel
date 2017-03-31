<?php

namespace App\Infra\Line\API\v2\Response;

class Verify
{
  var $scope;
  var $client_id;
  var $expires_in;

  public function __construct(array $data){
    $this->scope = $data[0];
    $this->client_id = $data[1];
    $this->expires_in = $data[2];
  }

  public function scope(){
    return $this->scope;
  }

  public function client_id(){
    return $this->client_id;
  }

  public function expires_in(){
    return $this->expires_in;
  }
}
