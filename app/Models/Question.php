<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends BaseModel
{
    use HasFactory;

    protected $table = 'questions';
    
    protected $fillable = [
        'subject_id',
        'subject_content_id',
        'level',
        'type',
        'content',
        'image',
        'score',
        'created_by',
        'review_by',
        'status',
    ];
}
