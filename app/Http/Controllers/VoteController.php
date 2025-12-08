<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Election;
use App\Models\Candidate;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index()
    {
        $student = Student::find(session('student_id'));

        if (!$student->isEligibleToVote()) {
        return view('Student.elections.ineligible'); // We show a message instead of elections
    }


        $elections = Election::where(function ($query) use ($student) {
            $query->where('scope', 'university')
                ->orWhere(function ($q) use ($student) {
                    $q->where('scope', 'faculty')
                        ->where('faculty_id', $student->faculty_id);
                })
                ->orWhere(function ($q) use ($student) {
                    $q->where('scope', 'course')
                        ->where('course_id', $student->course_id);
                });
        })
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get();

        return view('Student.elections.index', compact('elections', 'student'));
    }

   public function show(Election $election)
{
    // Get logged-in student
    $student = \App\Models\Student::find(session('student_id'));

    if (!$student) {
        return redirect()->route('student.login');
    }

    if (!$student->isEligibleToVote()) {
        return view('Student.elections.ineligible');
    }

    // Check if student already voted in this election
    $hasVoted = \App\Models\Vote::where('election_id', $election->id)
        ->where('voter_regno', $student->registration_number)
        ->exists();

    if ($hasVoted) {
        return view('Student.elections.voted', ['student' => $student, 'election' => $election]);
    }

    // Get candidates for this election
    $candidates = \App\Models\Candidate::where('election_id', $election->id)->get();

    return view('Student.elections.show', [
        'election' => $election,
        'candidates' => $candidates,
        'student' => $student,
    ]);
}


    public function vote(Request $request, Election $election)
    {
        $student = \App\Models\Student::find(session('student_id'));

        // Check if student is logged in
        if (!$student) {
            return redirect()->route('student.login');
        }

         if (!$student->isEligibleToVote()) {
        return redirect()->route('student.elections')->with('error', 'You are not eligible to vote.');
        }

        // Validate the selected candidate
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        // Check if already voted
        $hasVoted = \App\Models\Vote::where('election_id', $election->id)
            ->where('voter_regno', $student->registration_number)
            ->exists();

        if ($hasVoted) {
            return redirect()->back()->with('error', 'You have already voted in this election.');
        }

        // Record the vote
        \App\Models\Vote::create([
            'election_id' => $election->id,
            'candidate_id' => $request->candidate_id,
            'voter_regno' => $student->registration_number,
        ]);

        return redirect()->route('student.elections')->with('success', 'Your vote has been recorded. Thank you!');
    }
   
}




