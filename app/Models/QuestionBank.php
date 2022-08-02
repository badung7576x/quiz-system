<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
// use Elasticquent\ElasticquentTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class QuestionBank extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected $table = 'question_banks';

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
    }
    
    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'question_banks';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'content' => $this->content,
        ];
    }

    public function scopeActive($query)
    {
        $user = auth()->user();
        
        return $query->where('subject_id', $user->subject_id);
    }

    public function answers()
    {
        return $this->hasMany(AnswerBank::class, 'question_id', 'id');
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

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('H:i d/m/Y'),
        );
    }
}
