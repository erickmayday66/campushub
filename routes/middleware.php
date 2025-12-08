<?php

use App\Http\Middleware\Authenticate;

return [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'student.auth' => \App\Http\Middleware\EnsureStudentIsLoggedIn::class,
    'force.password.change' => \App\Http\Middleware\ForcePasswordChange::class,
    // Add other middleware aliases here
];
