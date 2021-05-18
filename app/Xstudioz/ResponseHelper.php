<?php


namespace App\Xstudioz;


class ResponseHelper
{
    static function success($msg, $data = [])
    {
        return response(['message' => $msg, 'data' => $data]);
    }

    static function error($msg, $data = [], $code = 404)
    {
        return response(['message' => $msg, 'data' => $data], $code);
    }
}
