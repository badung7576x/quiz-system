<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSetSetting extends Model
{
    use HasFactory;

    protected $table = 'exam_set_settings';

    protected $fillable = [
        'exam_set_id',
        'is_display_top',
        'top_left',
        'top_right',
        'is_display_center',
        'center',
        'is_display_bottom',
        'bottom'
    ];
}
