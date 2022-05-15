<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
  protected static function boot()
  {
    parent::boot();

    self::creating(function ($model) {
      $model->group_id = auth()->user()->group_id;
      $model->created_by = auth()->user()->id;
    });
  }
}
