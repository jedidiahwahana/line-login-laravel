<?php

namespace App\Infra\Line\API\v2\Response;

class Profile
{
  var $displayName;
  var $userId;
  var $pictureUrl;
  var $statusMessage;

  public function __construct(array $data){
    $this->displayName = $data[0];
    $this->userId = $data[1];
    $this->pictureUrl = $data[2];
    $this->statusMessage = $data[3];
  }

  public function displayName(){
    return $this->displayName;
  }

  public function userId(){
    return $this->userId;
  }

  public function pictureUrl(){
    return $this->pictureUrl;
  }

  public function statusMessage(){
    return $this->statusMessage;
  }
}
