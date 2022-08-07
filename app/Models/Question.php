<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends BaseModel
{
    use HasFactory, SoftDeletes;

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
            if(auth()->user()) {
                $model->created_by = auth()->user()->id;
                $model->status = QUESTION_STATUS_CREATED;
            }
        });
    }

    public function scopeActive($query)
    {
        $user = auth()->user();
        
        return $query->where('subject_id', $user->subject_id);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id')->orderBy('order');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'created_by', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(Teacher::class, 'review_by', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function subject_content()
    {
        return $this->belongsTo(SubjectContent::class, 'subject_content_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id', 'id');
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('H:i d/m/Y'),
        );
    }
}
