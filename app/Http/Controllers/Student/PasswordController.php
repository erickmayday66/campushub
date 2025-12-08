<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
   public function showChangeForm()
    {
        $student = Student::find(session('student_id'));
        if (!$student) {
            return redirect()->route('student.login');
        }

        return view('Student.change-password', ['student' => $student]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $student = Student::find(session('student_id'));

        if (!$student) {
            return redirect()->route('student.login');
        }

        $student->password = Hash::make($request->new_password);
        $student->must_change_password = false;
        $student->save();

        return redirect()->route('student.dashboard')->with('success', 'Password changed successfully.');
    }
}
