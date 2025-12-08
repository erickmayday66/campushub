<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::with('faculty')->get();
        return view('manager.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('manager.courses.create', compact('faculties'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'duration_years' => 'required|integer|min:1|max:10',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        Course::create($validated);

        return redirect()->route('manager.courses.index')->with('success', 'Course created.');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $faculties = Faculty::all();
        return view('manager.courses.edit', compact('course', 'faculties'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'code' => 'required|string|max:50',
            'duration_years' => 'required|integer|min:1|max:10',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $course->update($validated);

        return redirect()->route('manager.courses.index')->with('success', 'Course updated.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('manager.courses.index')->with('success', 'Course deleted.');
    }
}
