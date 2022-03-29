<?php

namespace App\Http\Traits;


trait ResponseTrait
{
  public function error($message)
  {
    return [
      'type' => 'error',
      'message' => $message
    ];
  }

  public function success($message)
  {
    return [
      'type' => 'success',
      'message' => $message
    ];
  }
}
