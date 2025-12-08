<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student | CampusHub</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/student/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-primary mb-4"><i class="fas fa-user-edit text-warning"></i> Edit Student</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following errors:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="registration_number" class="form-label">Registration Number</label>
                <input type="text" name="registration_number" id="registration_number" class="form-control"
                       value="{{ old('registration_number', $student->registration_number) }}" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ old('name', $student->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="course_id" class="form-label">Course</label>
                <select name="course_id" id="course_id" class="form-select" required>
                    <option disabled>-- Choose Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ $student->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->name }} ({{ $course->faculty->name ?? 'No Faculty' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Student</button>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</body>
</html>
