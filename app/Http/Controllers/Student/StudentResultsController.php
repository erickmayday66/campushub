<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Vote;
use App\Models\Candidate;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentResultsController extends Controller
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

        // Fetch elections visible to this student
        $elections = Election::where(function ($query) use ($student) {
                $query->where('scope', 'university')
                    ->orWhere(function ($q) use ($student) {
                        $q->where('scope', 'faculty')->where('faculty_id', $student->faculty_id);
                    })
                    ->orWhere(function ($q) use ($student) {
                        $q->where('scope', 'course')->where('course_id', $student->course_id);
                    });
            })
            ->orderByDesc('end_date')
            ->get();

        $results = [];

        foreach ($elections as $election) {
            $candidates = Candidate::where('election_id', $election->id)->get();

            $candidateResults = $candidates->map(function ($candidate) {
                $voteCount = Vote::where('candidate_id', $candidate->id)->count();
                $studentInfo = Student::where('registration_number', $candidate->student_regno)->first();

                return [
                    'candidate' => $candidate,
                    'student' => $studentInfo,
                    'votes' => $voteCount,
                ];
            });

            $results[] = [
                'election' => $election,
                'candidates' => $candidateResults->sortByDesc('votes'),
            ];
        }

        return view('Student.elections.results', compact('results', 'student'));
    }
}
