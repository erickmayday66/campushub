function fetchStudentDetails() {
    const regno = document.getElementById('student_regno').value;

    if (!regno.trim()) {
        alert("Please enter a registration number.");
        return;
    }

    fetch(`/manager/fetch-student/${encodeURIComponent(regno)}`)
        .then(response => {
            if (!response.ok) throw new Error("Student not found");
            return response.json();
        })
        .then(data => {
            document.getElementById('student-name').textContent = data.name;
            document.getElementById('student-course').textContent = data.course;
            document.getElementById('student-faculty').textContent = data.faculty;
            document.getElementById('course_id').value = data.course_id;

            document.getElementById('student-info').style.display = 'block';
        })
        .catch(error => {
            alert(error.message || "Could not fetch student.");
            document.getElementById('student-info').style.display = 'none';
        });
}