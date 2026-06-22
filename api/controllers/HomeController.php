<?php
class HomeController{

  public function index(){
    http_response_code(200);
    echo json_encode([
      "message" => "Hello world !",
      "status" => 200
    ]);
    exit;
  }

}