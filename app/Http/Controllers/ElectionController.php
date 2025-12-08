<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Course;
use App\Models\Faculty;

class ElectionController extends Controller
{
    public function index()
    {
        $elections = Election::with('course')->latest()->get();
        return view('manager.elections.index', compact('elections'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        $courses = Course::all();
        return view('manager.elections.create', compact('faculties', 'courses'));
    }

    public function store(Request $request)
    {
         $validated =$request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'scope' => 'required|in:university,faculty,course',
            'course_id' => 'nullable|exists:courses,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

            if ($request->scope === 'university') {
                $request->merge(['faculty_id' => null, 'course_id' => null]);
            } elseif ($request->scope === 'faculty') {
                $request->merge(['course_id' => null]);
            } elseif ($request->scope === 'course') {
                // assume faculty_id must be null, or keep if used
            }
    
        Election::create($request->only(['title', 'category', 'scope', 'start_date', 'end_date', 'course_id','faculty_id']));

        return redirect()->route('manager.elections.index')->with('success', 'Election created successfully.');
    }

    public function edit(Election $election)
    {
        $faculties = Faculty::all();
        $courses = Course::all();
        return view('manager.elections.edit', compact('election', 'courses', 'faculties'));
    }

    public function update(Request $request, Election $election)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'scope' => 'required|in:university,faculty,course',
            'faculty_id' => 'nullable|exists:faculties,id',
            'course_id' => 'nullable|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->scope === 'university') {
            $request->merge(['faculty_id' => null, 'course_id' => null]);
        } elseif ($request->scope === 'faculty') {
            $request->merge(['course_id' => null]);
        }

        $election->update($request->only([
            'title', 'category', 'scope', 'faculty_id', 'course_id', 'start_date', 'end_date'
        ]));

        return redirect()->route('manager.elections.index')->with('success', 'Election updated successfully.');
    }

    public function destroy(Election $election)
    {
        $election->delete();
        return redirect()->route('manager.elections.index')->with('success', 'Election deleted.');
    }

    public function quickCreate(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'scope' => 'required|in:university,faculty,course',
            'course_id' => 'nullable|exists:courses,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->scope === 'university') {
            $validated['faculty_id'] = null;
            $validated['course_id'] = null;
        } elseif ($request->scope === 'faculty') {
            $validated['course_id'] = null;
        }

        $election = Election::create($validated);

        return response()->json([
            'id' => $election->id,
            'title' => $election->title
        ]);
    }

}
