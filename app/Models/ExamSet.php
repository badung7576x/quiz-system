<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ExamSet extends Model
{
    use HasFactory;

    protected $table = 'exam_sets';

    protected $fillable = [
        'code',
        'name',
        'type',
        'subject_id',
        'subject_content_ids',
        'execute_time',
        'total_question',
        'answers',
        'status',
        'created_by',
        'parent_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
            $model->status = EXAM_SET_STATUS_CREATED;
        });
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_maps', 'exam_set_id', 'question_id')
            ->withPivot('order')->orderBy('order', 'asc');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function setting()
    {
        return $this->hasOne(ExamSetSetting::class, 'exam_set_id', 'id');
    }

    public function subjectContentIds(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => implode(',', $value),
        );
    }

    public function subjectContents(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $subjectContentIds = explode(',', $attributes['subject_content_ids']);
                return SubjectContent::whereIn('id', $subjectContentIds)->pluck('name');
            },
        );
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('H:i d/m/Y'),
        );
    }
}
