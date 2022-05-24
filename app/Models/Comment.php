<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    
    protected $fillable = [
        'comment_id',
        'question_id',
        'content',
        'is_resolved',
        'created_by',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
        });
    }

    public function commentor()
    {
        return $this->belongsTo(Teacher::class, 'created_by', 'id');
    }

    public function reply_comments()
    {
        return $this->hasMany(self::class, 'comment_id')->orderBy('created_at', 'asc');
    }
}
