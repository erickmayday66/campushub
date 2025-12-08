<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Student\AuthController as StudentAuth;
use App\Http\Controllers\FacultyController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Middleware\EnsureStudentIsLoggedIn;
use App\Http\Controllers\Student\PasswordController;
use App\Http\Controllers\Student\SettingsController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\ManagerSettingsController;
use App\Http\Controllers\Student\StudentResultsController;
// Homepage & Logout
Route::get('/', function () {
    return view('welcome');
});
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Breeze Auth (Admin & Manager)
require __DIR__.'/auth.php';

// Admin Dashboard & Routes
Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Results
        Route::get('/results', [AdminResultController::class, 'index'])->name('results.index');
        Route::get('/results/{election}', [AdminResultController::class, 'show'])->name('results.show');

        // Users (Admins/Managers)
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Students Resource
        Route::resource('students', StudentController::class);
        Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');

        // Fetch student by registration number (handles slashes)
        Route::get('/fetch-student/{regno}', [CandidateController::class, 'fetchStudent'])
            ->name('fetch.student')
            ->where('regno', '.*');
    });

// Manager Dashboard & Routes
Route::middleware(['auth', RoleMiddleware::class . ':manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

       Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

        // Faculties, Courses, Elections, Candidates Resource Controllers
        Route::resource('faculties', FacultyController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('elections', ElectionController::class);
        Route::resource('candidates', CandidateController::class);

        // Settings
        Route::get('/settings/edit', [ManagerSettingsController::class, 'edit'])->name('settings.edit');
        Route::post('/settings/update', [ManagerSettingsController::class, 'update'])->name('settings.update');

        //quick Election
        Route::post('/elections/quick-create', [ElectionController::class, 'quickCreate'])->name('elections.quick-create');

        // Password change
        Route::get('/settings/password/edit', [ManagerSettingsController::class, 'editPassword'])->name('settings.password.edit');
        Route::post('/settings/password/update', [ManagerSettingsController::class, 'updatePassword'])->name('settings.password.update');
        
        // Fetch student by registration number (handles slashes)
        Route::get('/fetch-student/{regno}', [CandidateController::class, 'fetchStudent'])
            ->name('fetch.student')
            ->where('regno', '.*');
    });

// Profile Settings (Admin & Manager)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// -------------------------
// Student Authentication Routes
// -------------------------
Route::get('/student/login', [StudentAuth::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentAuth::class, 'login']);
Route::post('/student/logout', [StudentAuth::class, 'logout'])->name('student.logout');

// -------------------------
// Student Password Change Routes
// -------------------------
Route::get('/student/change-password', [PasswordController::class, 'showChangeForm'])->name('student.password.change');
Route::post('/student/change-password', [PasswordController::class, 'updatePassword'])->name('student.change-password.update');

// -------------------------
// Student Dashboard (Protected)
// -------------------------
Route::middleware([EnsureStudentIsLoggedIn::class, ])->group(function () {

    // -------------------------
    // Student Dashboard (Protected)
    // -------------------------
    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
    // -------------------------
    // Voting Routes (Student)
    // -------------------------
    Route::get('/elections', [VoteController::class, 'index'])->name('student.elections');
    Route::get('/elections/{election}', [VoteController::class, 'show'])->name('student.elections.show');
    Route::post('/elections/{election}/vote', [VoteController::class, 'vote'])->name('student.elections.vote');

    // Student settings page (theme toggle + link to change password)
    Route::get('/student/settings', [SettingsController::class, 'index'])->name('student.settings');


    // Profile page
    Route::get('/student/profile', [ProfileController::class, 'index'])->name('student.profile');

    // Results page (based on course/faculty/university)
    Route::get('/student/results', [StudentResultsController::class, 'index'])->name('student.results');


});