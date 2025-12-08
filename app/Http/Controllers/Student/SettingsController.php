<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class SettingsController extends Controller
{
    public function index()
    {
        $studentId = session('student_id'); // Or use auth()->id() if using Laravel's auth
        $student = Student::find($studentId);

        return view('Student.settings', compact('student'));
    }
}
