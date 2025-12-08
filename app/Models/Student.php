<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $fillable = [
        'name',
        'registration_number',
        'course_id',
        'faculty_id',
        'registration_year',
        'password'
        ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function isEligibleToVote(): bool
    {
        $currentYear = now()->year;
        return $currentYear <= ($this->registration_year + $this->course->duration_years - 1);
    }
}
