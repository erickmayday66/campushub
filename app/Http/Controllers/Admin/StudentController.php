<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{
    // List all students
    public function index()
    {
        $students = Student::with('course.faculty')->orderBy('registration_number')->get();
        return view('admin.students.index', compact('students'));
    }

    // Show the form to add a new student
    public function create()
    {
        $courses = Course::with('faculty')->orderBy('name')->get();
        return view('admin.students.create', compact('courses'));
    }

    // Show the form to edit a student
    public function edit(Student $student)
    {
        $courses = Course::with('faculty')->orderBy('name')->get();
        return view('admin.students.edit', compact('student', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'registration_number' => 'required|string|unique:students',
        'course_id' => 'required|exists:courses,id',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $course = Course::find($request->course_id);

    $year = substr($request->registration_number, 0, 4); 

    Student::create([
        'name' => $request->name,
        'registration_number' => $request->registration_number,
        'course_id' => $request->course_id,
        'faculty_id' => $course->faculty_id,
        'registration_year' => $year, // <-- Add this
        'password' => bcrypt($request->password),
         'must_change_password' => true, 
    ]);

         return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function update(Request $request, Student $student)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'registration_number' => 'required|string|unique:students,registration_number,' . $student->id,
        'course_id' => 'required|exists:courses,id',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $student->name = $validated['name'];
    $student->registration_number = $validated['registration_number'];
    $student->course_id = $validated['course_id'];

    // If password is provided, update it
    if (!empty($validated['password'])) {
        $student->password = bcrypt($validated['password']);
    }

    // Optional: Update faculty_id automatically from selected course
    $student->faculty_id = $student->course->faculty_id ?? null;

    // Optional: Auto extract registration year
    $student->registration_year = substr($student->registration_number, 0, 4);

    $student->save();

    return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
}

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
    }



    public function searchStudent($regno)
    {
        $student = Student::with(['course.faculty'])
            ->where('registration_number', $regno)
            ->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json([
            'name' => $student->name,
            'course' => $student->course->name ?? '',
            'faculty' => $student->course->faculty->name ?? '',
            'course_id' => $student->course_id,
            'faculty_id' => $student->faculty_id,
        ]);
    }


public function import(Request $request)
{
    set_time_limit(300);

    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    $rows = \PhpOffice\PhpSpreadsheet\IOFactory::load(
        $request->file('file')->getRealPath()
    )->getActiveSheet()->toArray(null, true, true, true);

    unset($rows[1]); // header

    // 🔥 Load courses once
    $courses = \App\Models\Course::with('faculty')->get()
        ->keyBy(fn ($c) => trim($c->name));

    // 🔥 Load existing students once
    $existingRegNos = \App\Models\Student::pluck('registration_number')->flip();

    $passwordCache = [];
    $insertData = [];

    foreach ($rows as $row) {
        $name = trim($row['A'] ?? '');
        $regNo = trim($row['B'] ?? '');
        $courseName = trim($row['C'] ?? '');

        if ($name === '' || $regNo === '' || $courseName === '') continue;
        if (isset($existingRegNos[$regNo])) continue;

        $course = $courses[$courseName] ?? null;
        if (!$course) continue;

        // SAME LOGIC
        $parts = preg_split('/\s+/', $name);
        $lastName = strtoupper(end($parts));

        if (!isset($passwordCache[$lastName])) {
            $passwordCache[$lastName] = \Hash::make($lastName);
        }

        $insertData[] = [
            'name' => $name,
            'registration_number' => $regNo,
            'course_id' => $course->id,
            'faculty_id' => $course->faculty->id ?? null,
            'registration_year' => (int) substr($regNo, 0, 4),
            'password' => $passwordCache[$lastName],
            'must_change_password' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // 🔥 Insert in chunks
        if (count($insertData) === 500) {
            \DB::table('students')->insert($insertData);
            $insertData = [];
        }
    }

    if (!empty($insertData)) {
        \DB::table('students')->insert($insertData);
    }

    return back()->with('success', 'Students imported successfully!');
}
}