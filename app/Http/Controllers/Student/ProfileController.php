<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Faculty;

class ProfileController extends Controller
{
   public function index()
    {
        $student = Student::with(['course', 'faculty'])->find(session('student_id'));

        if (!$student) {
            return redirect()->route('student.login');
        }

        return view('Student.profile', compact('student'));
    }
}
