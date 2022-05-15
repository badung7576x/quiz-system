<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectContent extends Model
{
    use HasFactory;

    protected $table = 'subject_contents';

    protected $fillable = [
        'subject_id',
        'order',
        'name',
        'description',
    ];
}
