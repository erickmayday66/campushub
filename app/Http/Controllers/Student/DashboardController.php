<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Student;
use App\Models\Vote;

class DashboardController extends Controller
{
    public function index()
{
    $student = Student::find(session('student_id'));

    if (!$student) {
        return redirect()->route('student.login');
    }

    // Check if graduated
    $graduationYear = $student->registration_year + $student->course->duration_years;
    $currentYear = now()->year;

    if ($currentYear > $graduationYear) {
        return view('Student.elections.ineligible', ['student' => $student]);
    }

    // All active elections student is eligible for
    $eligibleElections = Election::where(function ($query) use ($student) {
            $query->where('scope', 'university')
                ->orWhere(function ($q) use ($student) {
                    $q->where('scope', 'faculty')->where('faculty_id', $student->faculty_id);
                })
                ->orWhere(function ($q) use ($student) {
                    $q->where('scope', 'course')->where('course_id', $student->course_id);
                });
        })
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get();

    // All election IDs student already voted for
    $votedElectionIds = Vote::where('voter_regno', $student->registration_number)
                            ->pluck('election_id')
                            ->toArray();

    // Count of votes casted
    $votesCasted = count($votedElectionIds);

    // Elections student has not voted in yet
    $pendingElections = $eligibleElections->filter(function ($election) use ($votedElectionIds) {
        return !in_array($election->id, $votedElectionIds);
    });

    return view('Student.dashboard', [
        'student' => $student,
        'elections' => $eligibleElections,
        'votesCasted' => $votesCasted,
        'pendingVotes' => $pendingElections,
    ]);
}

}
