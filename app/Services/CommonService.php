<?php

namespace App\Services;

class CommonService
{

  public function getRoles()
  {
    $user = auth()->user();
    $roles = config('fixeddata.role');

    if ($user->role != ROLE_ADMIN) {
      unset ($roles[ROLE_ADMIN]);
      return $roles;
    }

    return $roles;
  }
}
