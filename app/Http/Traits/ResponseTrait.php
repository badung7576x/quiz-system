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

  public function redirectSuccess($route, $message, $params = null)
  {
    return redirect()->route($route, $params)
      ->with($this->success(__('messages.' . $message . '.success')));
  }

  public function redirectError($type, $message = null)
  {
    $errorMsg = $message ? $message : __('messages.' . $type . '.error');
    return back()->withInput()->with($this->error($errorMsg));
  }

  public function redirectBackWithSuccess($message)
  {
    return redirect()->back()
      ->with($this->success(__('messages.' . $message . '.success')));
  }
}
