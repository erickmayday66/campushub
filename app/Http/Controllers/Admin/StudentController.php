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
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');
    $rows = IOFactory::load($file->getRealPath())->getActiveSheet()->toArray(null, true, true, true);

    unset($rows[1]); // skip header

    foreach ($rows as $row) {
        $name = $row['A'] ?? null;
        $regNo = $row['B'] ?? null;
        $courseName = $row['C'] ?? null;

        if (!$name || !$regNo || !$courseName) {
            continue;
        }

        $course = \App\Models\Course::with('faculty')->where('name', $courseName)->first();
        if (!$course) {
            continue;
        }

        $exists = \App\Models\Student::where('registration_number', $regNo)->exists();
        if ($exists) continue;

        $registrationYear = intval(substr($regNo, 0, 4)); // this will be 2023 from 2023/0455

        \App\Models\Student::create([
            'name' => $name,
            'registration_number' => $regNo,
            'course_id' => $course->id,
            'faculty_id' => $course->faculty->id ?? null,
            'registration_year' => $registrationYear,
            'password' => Hash::make('12345678'),
            'must_change_password' => true,
        ]);
    }

    return redirect()->back()->with('success', 'Students imported successfully!');
}


}

