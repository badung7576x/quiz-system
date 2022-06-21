<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description'
    ];

    public function contents()
    {
        return $this->hasMany(SubjectContent::class, 'subject_id', 'id');
    }
}
