<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = \App\Models\Faculty::select('id', 'name', 'code', 'created_at')->get();
        return view('manager.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('manager.faculties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:faculties,name',
            'code' => 'required|unique:faculties,code',
        ]);

        Faculty::create([
        'name' => $request->name,
        'code' => $request->code,
    ]);

    return redirect()->route('manager.faculties.index')->with('success', 'Faculty created.');
    }

    public function edit(Faculty $faculty)
    {
        return view('manager.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|unique:faculties,name,' . $faculty->id,
              'code' => 'required|unique:faculties,code,' . $faculty->id,
        ]);

        $faculty->update([
        'name' => $request->name,
        'code' => $request->code,
    ]);

    return redirect()->route('manager.faculties.index')->with('success', 'Faculty updated.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return redirect()->route('manager.faculties.index')->with('success', 'Faculty deleted.');
    }
}
