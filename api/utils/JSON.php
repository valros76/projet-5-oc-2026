<?php
class JSON
{

  public static function response($message = "", $status = 200, ...$params)
  {
    http_response_code($status);
    echo json_encode([
      "message" => $message,
      "status" => $status,
      "params" => [...$params]
    ]);
    exit;
  }
}
