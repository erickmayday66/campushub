<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Course;
use App\Models\Election;
use App\Models\Student;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the candidates.
     */
    public function index()
    {
        $candidates = Candidate::latest()->paginate(10);
        return view('manager.candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new candidate.
     */
    public function create()
    {
        $students = \App\Models\Student::with(['course.faculty'])->get();
        $elections = \App\Models\Election::all();
        return view('manager.candidates.create', compact('students', 'elections'));
    }

    /**
     * Store a newly created candidate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_regno' => 'required|string|unique:candidates,student_regno,NULL,id,election_id,' . $request->election_id,
            'election_id'   => 'required|exists:elections,id',
            'policies'      => 'required|string',
            'image'         => 'nullable|image|max:2048',
        ]);

        // Get student by registration number
        $student = Student::where('registration_number', $request->student_regno)->first();

        if (!$student) {
            return back()->withErrors(['student_regno' => 'Student not found in the system.']);
        }

        $validated['course_id'] = $student->course_id;
        $validated['faculty_id'] = $student->faculty_id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('candidate_images', 'public');
        }

        Candidate::create($validated);

        return redirect()->route('manager.candidates.index')->with('success', 'Candidate added successfully.');
    }

    /**
     * Show the form for editing the specified candidate.
     */
    public function edit(Candidate $candidate)
    {
        $students = Student::with('course.faculty')->get();
            
        $elections = Election::all();

        return view('manager.candidates.edit', compact('candidate', 'elections', 'students'));
    }

    /**
     * Update the specified candidate in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'student_regno' => 'required|string|unique:candidates,student_regno,' . $candidate->id . ',id,election_id,' . $request->election_id,
            'election_id'   => 'required|exists:elections,id',
            'policies'      => 'required|string',
            'image'         => 'nullable|image|max:2048',
        ]);

        $student = Student::where('registration_number', $request->student_regno)->first();

        if (!$student) {
            return back()->withErrors(['student_regno' => 'Student not found.']);
        }

        $validated['course_id'] = $student->course_id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('candidate_images', 'public');
        }

        $candidate->update($validated);

        return redirect()->route('manager.candidates.index')->with('success', 'Candidate updated successfully.');
    }

    /**
     * Remove the specified candidate from storage.
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('manager.candidates.index')->with('success', 'Candidate deleted successfully.');
    }

    /**
     * Fetch student details by registration number.
     */
    public function fetchStudent($regno)
    {
        $student = Student::with('course.faculty')->where('registration_number', $regno)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json([
            'name'        => $student->name,
            'course'      => $student->course->name ?? '',
            'faculty'     => $student->course->faculty->name ?? '',
            'course_id'   => $student->course_id,
            'faculty_id'  => $student->faculty_id,
        ]);
    }
}