<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'duration_years',
        'faculty_id',
    ];

    /**
     * Get the faculty that owns the course.
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
