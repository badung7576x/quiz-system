<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerBank extends Model
{
    use HasFactory;

    protected $table = 'answer_banks';
    
    protected $fillable = [
        'question_id',
        'order',
        'content_1',
        'content_2',
        'image',
        'is_correct'
    ];
}
