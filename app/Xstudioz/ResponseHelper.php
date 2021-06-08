<?php


namespace App\Xstudioz;


class ResponseHelper
{
  static function success($msg, $data = [])
  {
    return response(['message' => $msg, 'type' => 'success', 'data' => $data]);
  }

  static function error($msg, $data = [], $code = 404)
  {
    return response(['message' => $msg, 'type' => 'error', 'data' => $data], $code);
  }
}
