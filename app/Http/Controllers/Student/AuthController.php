<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Student.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'registration_number' => 'required',
            'password' => 'required',
        ]);

        $student = Student::where('registration_number', $request->registration_number)->first();

        if ($student && Hash::check($request->password, $student->password)) {
            session(['student_id' => $student->id]);

            // Check if password must be changed
            if ($student->must_change_password) {
                return redirect()->route('student.password.change');
            }

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors(['registration_number' => 'Invalid credentials']);
    }


    public function logout()
    {
        session()->forget('student_id');
        return redirect()->route('student.login');
    }

    public function showChangePasswordForm()
{
    return view('student.auth.change-password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'password' => 'required|string|confirmed|min:8',
    ]);

    $student = Student::find(session('student_id'));

    if (!$student) {
        return redirect()->route('student.login')->withErrors(['error' => 'Unauthorized']);
    }

    $student->password = bcrypt($request->password);
    $student->must_change_password = false;
    $student->save();

    return redirect()->route('student.dashboard')->with('success', 'Password changed successfully.');
}

}
