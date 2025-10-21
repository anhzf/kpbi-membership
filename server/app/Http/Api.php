<?php

namespace App\Http;

class Api
{
    public static function data($data = null)
    {
        return response()->json([
            'data' => $data
        ]);
    }

    public static function message(string $message, $status = 200)
    {
        return response()->json(compact('message'), $status);
    }
}
