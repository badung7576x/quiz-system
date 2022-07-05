<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSetDetail extends Model
{
    use HasFactory;

    protected $table = 'exam_set_details';

    protected $fillable = [
        'exam_set_id',
        'code',
        'question_order',
        'answers'
    ];

    public function examSet()
    {
        return $this->belongsTo(ExamSet::class, 'exam_set_id', 'id');
    }
}
