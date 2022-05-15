<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
            $model->status = QUESTION_STATUS_CREATED;
        });
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('H:i d/m/Y'),
        );
    }
}
