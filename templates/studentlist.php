<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../db/connection.php';
require_once __DIR__ . '/../functions.php';

// Get filters
$selectedCourse = $_GET['course'] ?? '';
$selectedProgram = $_GET['program'] ?? '';

// Get data
$courses = getCourses($conn);
$programs = getPrograms($conn);
$students = filterStudents($conn, $selectedCourse, $selectedProgram);
?>
<div class="container py-6">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Student List</h2>
        <div class="display-flex">
            <form method="GET" class="mb-3" id="filterForm" onsubmit="return handleFilterSubmit(event);">
                <div class="d-flex align-items-center">
                    <select style="width: 150%" name="course" class="form-select" id="courseSelect">
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= htmlspecialchars($course) ?>" <?= $selectedCourse === $course ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select style="width: 150%" name="program" class="form-select" id="programSelect">
                        <option value="">Select Program</option>
                        <?php foreach ($programs as $program): ?>
                            <option value="<?= htmlspecialchars($program) ?>" <?= $selectedProgram === $program ? 'selected' : '' ?>>
                                <?= htmlspecialchars($program) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <div class="d-flex align-items-center">
            <div id="actionButtons" style="display: none; margin-right: 10px;">
                <button type="button" class="btn btn-success" onclick="addStudent()">Add</button>
                <button type="button" class="btn btn-warning" onclick="editStudent()">Edit</button>
                <button type="button" class="btn btn-danger" onclick="deleteStudent()">Delete</button>
            </div>
            <button type="button" class="btn update-content-btn" id="updateButton" onclick="toggleActionButtons()">Update Content</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Program</th>
                    <th>Profile</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students && $students->num_rows > 0): ?>
                    <?php $currentNumber = 1; while ($row = $students->fetch_assoc()): ?>
                        <tr>
                            <td style="text-align:center" class="p-1"><?= $currentNumber++ ?></td>
                            <td class="p-1"><?= htmlspecialchars($row['Student_Name']) ?></td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($row['Course_Name']) ?></td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($row['Program_Year']) ?></td>
                            <td style="text-align:center" class="p-1">
                                <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No students found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function handleFilterSubmit(event) {
    event.preventDefault();
    const course = document.getElementById('courseSelect').value;
    const program = document.getElementById('programSelect').value;
    let url = 'http://localhost/SYSTEM/index.php?page=studentlist';
    
    if (course) url += '&course=' + encodeURIComponent(course);
    if (program) url += '&program=' + encodeURIComponent(program);
    
    window.location.href = url;
}

function addStudent() {
    const name = prompt("Enter Student Name:");
    if (!name) return;

    const course = prompt("Enter Course:");
    if (!course) return;

    const program = prompt("Enter Program:");
    if (!program) return;

    fetch('api/add_student.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ 
            name: name,
            course: course,
            program: program 
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            throw new Error(data.message || 'Failed to add student');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
}

function toggleActionButtons() {
    const actionButtons = document.getElementById('actionButtons');
    const updateButton = document.getElementById('updateButton');

    if (actionButtons.style.display === 'none' || actionButtons.style.display === '') {
        actionButtons.style.display = 'block';
        updateButton.textContent = 'Save Changes';
    } else {
        actionButtons.style.display = 'none';
        updateButton.textContent = 'Update Content';
    }
}

// Placeholder functions for future implementation
function editStudent() {
    alert("Edit functionality will be implemented here");
}

function deleteStudent() {
    alert("Delete functionality will be implemented here");
}
</script>
