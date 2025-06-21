<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include connection first
require_once __DIR__ . '/../db/connection.php'; // Use absolute path
// Then include functions
require_once __DIR__ . '/../functions.php';

// Pagination setup
$limit = 10; // Number of students per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page
$page = max(1, $page); // Ensure page is at least 1
$offset = ($page - 1) * $limit; // Calculate offset

// Get selected filter and value from the request
$selectedCourse = $_GET['course'] ?? '';
$selectedProgram = $_GET['program'] ?? '';

// Get all courses and programs
$courses = getCourses($conn);
$programs = getPrograms($conn);

// Get total count of students (without pagination)
$totalStudents = countStudents($conn, $selectedCourse, $selectedProgram);
$totalPages = ceil($totalStudents / $limit); // Calculate total pages

// Get students for current page (with pagination)
$students = filterStudents($conn, $selectedCourse, $selectedProgram, $limit, $offset);

// Fetch grades based on the selected course
$grades = [];
if ($selectedCourse) {
    $query = "SELECT student_name, program_year, assignment_name, assignment_score, assignment_range, percentage 
              FROM grades 
              WHERE course_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selectedCourse);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $grades[] = [
            'name' => $row['student_name'],
            'program' => $row['program_year'],
            'assignment' => $row['assignment_name'], // Default to 'N/A' if empty
            'range' => $row['assignment_range']?: ' ',
            'score' => $row['assignment_score'] ?: ' ', // Default to 'N/A' if empty
            'percent' => $row['percentage'] ?: 0 // Default to 0 if empty
        ];
    }
}
?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-3">Grades</h1>
        <div>
            <!-- Program Filter -->
            <form method="GET" class="mb-3">
                <input type="hidden" name="course" value="<?= htmlspecialchars($selectedCourse) ?>">
                <select style="width: 150%" name="course" class="form-select" onchange="this.form.submit()">
                    <option value=""><?= htmlspecialchars($selectedCourse) ?></option>
                    <?php foreach ($courses as $courses): ?>
                        <option value="<?= htmlspecialchars($courses) ?>" <?= $selectedCourse === $courses ? 'selected' : '' ?>>
                            <?= htmlspecialchars($courses) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div style="margin: 0px 70px 0px;">
            <button type="button" class="btn update-content-btn">
                <a style="text-decoration: none; color: white;" href="index.php?page=attendance-edit">Update Content</a>
            </button>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Program</th>
                <th>Activity</th>
                <th>Score</th>
                <th>Range</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $grade): ?>
            <tr>
                <td><?= htmlspecialchars($grade['name']) ?></td>
                <td><?= htmlspecialchars($grade['program']) ?></td>
                <td><?= htmlspecialchars($grade['assignment']) ?></td>
                <td><?= htmlspecialchars($grade['score']) ?></td>
                <td><?= htmlspecialchars($grade['range']) ?></td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" style="width: <?= htmlspecialchars($grade['percent']) ?>%">
                            <?= htmlspecialchars($grade['percent']) ?>%
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($grades)): ?>
                <tr>
                    <td colspan="5" class="text-center">No grades available for this course.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?course=<?= urlencode($selectedCourse) ?>&program=<?= urlencode($selectedProgram) ?>&page=<?= $page - 1 ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?course=<?= urlencode($selectedCourse) ?>&program=<?= urlencode($selectedProgram) ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?course=<?= urlencode($selectedCourse) ?>&program=<?= urlencode($selectedProgram) ?>&page=<?= $page + 1 ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>