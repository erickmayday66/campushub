<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'voter_regno', 'election_id', 'candidate_id'
    ];

    /**
     * Get the election this vote belongs to.
     */
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    /**
     * Get the candidate that was voted for.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the student who cast this vote.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
