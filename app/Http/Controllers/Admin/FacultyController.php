<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
   public function index()
    {
        $faculties = Faculty::select('id', 'name', 'code', 'created_at')->get();
        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
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

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty created.');
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
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

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty updated.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty deleted.');
    }
}
