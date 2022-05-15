<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionSet extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'subject_id',
        'set_name'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_set_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
