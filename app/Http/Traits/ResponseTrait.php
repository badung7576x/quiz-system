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

  public function redirectSuccess($route, $message)
  {
    return redirect()->route($route)
      ->with($this->success(__('messages.' . $message . '.success')));
  }

  public function redirectError($message)
  {
    return back()->withInput()->with($this->error(__('messages.' . $message . '.error')));
  }
}
