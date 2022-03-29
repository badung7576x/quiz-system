<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id', 'name', 'description', 'created_by'
    ];

    protected static function boot() {

        parent::boot();

        self::creating(function ($model) {
            $model->group_id = auth()->user()->group_id;
            $model->created_by = auth()->user()->id;
        });
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id', 'id');
    }
}
