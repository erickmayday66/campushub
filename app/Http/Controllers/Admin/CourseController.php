<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Faculty;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('faculty')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.courses.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name',
            'code' => 'required|string|max:50|unique:courses,code',
            'duration_years' => 'required|integer|min:1|max:10',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created.');
    }

    public function edit(Course $course)
    {
        $faculties = Faculty::all();
        return view('admin.courses.edit', compact('course', 'faculties'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $course->id,
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'duration_years' => 'required|integer|min:1|max:10',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }
}
