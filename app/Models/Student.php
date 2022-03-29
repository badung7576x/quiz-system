<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id', 'student_code', 'first_name', 'last_name', 'gender', 'date_of_birth'
    ];

    protected $appends = ['full_name'];

    public function dateOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y'),
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_name . ' ' . $this->first_name,
        );
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }


}
