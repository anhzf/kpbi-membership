<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
  public function send($data, string $message = null)
  {
    return response()->json([
      'success' => true,
      'data' => $data,
      'message' => $message,
    ], 200);
  }

  public function sendError(string $message, $code = 500, $data = null)
  {
    return response()->json([
      'success' => false,
      'message' => $message,
      'data' => $data,
    ], $code);
  }
}
