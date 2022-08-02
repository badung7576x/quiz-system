<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subject_contents';

    protected $fillable = [
        'subject_id',
        'order',
        'name',
    ];
    
    public function scopeActive($query)
    {
        $user = auth()->user();
        
        return $query->where('subject_id', $user->subject_id);
    }
}
