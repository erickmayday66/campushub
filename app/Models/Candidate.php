<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_regno',
        'election_id',
        'course_id',
        'policies',
        'image',
    ];

    // Relationships
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function votes()
    {
        return $this->hasMany(\App\Models\Vote::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_regno', 'registration_number');
    }
}
