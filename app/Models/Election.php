<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Election extends Model
{
     use HasFactory;

     protected $fillable = ['title', 'category', 'scope', 'start_date', 'end_date', 'course_id','faculty_id'];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }


    public function candidates()
    {
        return $this->hasMany(\App\Models\Candidate::class);
    }

}
