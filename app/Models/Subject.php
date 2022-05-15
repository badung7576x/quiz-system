<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function contents()
    {
        return $this->hasMany(SubjectContent::class, 'subject_id', 'id');
    }
}
