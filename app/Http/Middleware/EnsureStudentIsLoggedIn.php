<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStudentIsLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('student_id')) {
            return redirect()->route('student.login');
        }

        return $next($request);
    }
}
