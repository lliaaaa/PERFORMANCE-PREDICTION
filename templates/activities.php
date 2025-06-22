<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../db/connection.php'; // Use absolute path
require_once __DIR__ . '/../functions.php';

// Get selected filter and value from the request
$selectedCourse = $_GET['course'] ?? '';
$selectedProgram = $_GET['program'] ?? '';

// Get all courses and programs
$courses = getCourses($conn);
$programs = getPrograms($conn);

// Fetch grades based on the selected course and program
$grades = [];
$query = "SELECT student_name, program_year, percentage, status 
          FROM grades 
          WHERE 1=1"; // Start with a base query

// Add filters to the query
if ($selectedCourse) {
    $query .= " AND course_name = ?";
}
if ($selectedProgram) {
    $query .= " AND program_year = ?";
}

$stmt = $conn->prepare($query);

// Bind parameters based on which filters are applied
if ($selectedCourse && $selectedProgram) {
    $stmt->bind_param("ss", $selectedCourse, $selectedProgram);
} elseif ($selectedCourse) {
    $stmt->bind_param("s", $selectedCourse);
} elseif ($selectedProgram) {
    $stmt->bind_param("s", $selectedProgram);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $grades[] = [
        'name' => $row['student_name'],
        'percent' => $row['percentage'] ?: 0, // Default to 0 if empty
        'status' => $row['status'] ?: '' // Default to '' if empty
    ];
}
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Activities</h2>
        <div class="display-flex">
            <!-- Course and Program Filter -->
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

    <!-- Student Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Percentage</th>
                    <th>Status</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($grades && count($grades) > 0): ?>
                    <?php 
                    $currentNumber = 1; // Start numbering from 1
                    
                    foreach ($grades as $grade): ?>
                        <tr>
                            <td style="text-align:center" class="p-1"><?= $currentNumber++ ?></td>
                            <td class="p-1"><?= htmlspecialchars($grade['name']) ?></td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" style="width: <?= htmlspecialchars($grade['percent']) ?>%">
                                        <?= htmlspecialchars($grade['percent']) ?>%
                                    </div>
                                </div>
                            </td>
                            <td class="p-1"><?= htmlspecialchars($grade['status']) ?></td>
                            <td style="text-align:center;color: #8B0000" class="p-1"><a href="#" class="btn btn-sm btn-outline-primary">View Details</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">No grades available for this course.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<script>
function handleFilterSubmit(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get selected values
    const course = document.getElementById('courseSelect').value;
    const program = document.getElementById('programSelect').value;

    // Call the filterAction function with selected values
    filterAction(course, program);
}

function filterAction(course, program) {
    let url = 'http://localhost/SYSTEM/index.php?page=activities';

    // Check if course is selected
    if (course) {
        url += '&course=' + encodeURIComponent(course);
    }

    // Check if program is selected
    if (program) {
        url += '&program=' + encodeURIComponent(program);
    }

    // Redirect to the constructed URL
    window.location.href = url;
}
</script>
