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
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Student List</h2>
        <?= renderFilterForm($selectedCourse, $selectedProgram, $courses, $programs); ?>
        <div style="margin: 0px 10px 0px;">
            <button type="button" class="btn update-content-btn">
                <a style="text-decoration: none; color: white;" href="index.php?page=attendance-edit">Update Content</a>
            </button>
        </div>
    </div>

    <!-- Student Table -->
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
                    <?php 
                    $startingNumber = ($page - 1) * $limit + 1;
                    $currentNumber = $startingNumber;
                    
                    while ($row = $students->fetch_assoc()): ?>
                        <tr>
                            <td style="text-align:center" class="p-1"><?= $currentNumber++ ?></td>
                            <td class="p-1"><?= htmlspecialchars($row['Student_Name']) ?></td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($row['Course_Name']) ?></td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($row['Program_Year']) ?></td>
                            <td style="text-align:center" class="p-1"><a href="#" class="btn btn-sm btn-outline-primary">View Details</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No students found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&course=<?= urlencode($selectedCourse) ?>&program=<?= urlencode($selectedProgram) ?>" tabindex="-1">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&course=<?= urlencode($selectedCourse) ?>&program=<?= urlencode($selectedProgram) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&course=<?= urlencode($selectedCourse) ?>&program=<?= urlencode($selectedProgram) ?>">Next</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<style>
    .table th, .table td {
        padding: 25px; /* Adjust padding to make rows thinner */
        font-size: 17px; /* Optional: Adjust font size */
    }
    th {
        text-align: center;
        background-color: #8B0000;
    }
</style>

<script>
function updateValueDropdown() {
    const filterBy = document.getElementById('filterBy');
    const filterValue = document.getElementById('filterValue');
    const selectedValue = filterValue.value; // Remember current selection
    
    // Clear options but keep "All Values"
    filterValue.innerHTML = '<option value="">All Values</option>';
    
    if (filterBy.value === 'course') {
        <?php foreach ($courses as $course): ?>
            filterValue.innerHTML += '<option value="<?= htmlspecialchars($course) ?>"><?= htmlspecialchars($course) ?></option>';
        <?php endforeach; ?>
    } 
    else if (filterBy.value === 'program') {
        <?php foreach ($programs as $program): ?>
            filterValue.innerHTML += '<option value="<?= htmlspecialchars($program) ?>"><?= htmlspecialchars($program) ?></option>';
        <?php endforeach; ?>
    }
    
    // Restore selection if possible
    if (selectedValue && [].some.call(filterValue.options, opt => opt.value === selectedValue)) {
        filterValue.value = selectedValue;
    }
}

// Initialize the dropdown on page load
document.addEventListener('DOMContentLoaded', function() {
    updateValueDropdown();
});
</script>
