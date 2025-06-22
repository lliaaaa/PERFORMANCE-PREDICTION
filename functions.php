<?php
function getCourses($conn) {
    return fetchColumn($conn, "SELECT Course_Name FROM courses");
}

function getPrerequisites($conn) {
    return fetchColumn($conn, "SELECT Prerequisite_Name FROM prerequisites");
}

function getPrograms($conn) {
    return fetchColumn($conn, "SELECT DISTINCT Program_Year FROM studentlist");
}

function fetchColumn($conn, $query) {
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = reset($row); // Get the first column value
    }
    return $data;
}

function countStudents($conn, $selectedCourse = null, $selectedProgram = null) {
    $query = "SELECT COUNT(*) as total FROM studentlist WHERE 1=1";
    if ($selectedCourse) {
        $query .= " AND Course_Name = '" . $conn->real_escape_string($selectedCourse) . "'";
    }
    if ($selectedProgram) {
        $query .= " AND Program_Year = '" . $conn->real_escape_string($selectedProgram) . "'";
    }
    return $conn->query($query)->fetch_assoc()['total'];
}
function filterStudents($conn, $selectedCourse = null, $selectedProgram = null) {
    $query = "SELECT * FROM studentlist WHERE 1=1"; // Start with a base query

    if ($selectedCourse) {
        $query .= " AND Course_Name = '" . $conn->real_escape_string($selectedCourse) . "'";
    }

    if ($selectedProgram) {
        $query .= " AND Program_Year = '" . $conn->real_escape_string($selectedProgram) . "'";
    }

    return $conn->query($query);
}


function renderFilterForm($selectedCourse, $selectedProgram, $courses, $programs) {
    ob_start(); 
    ?>
    <form method="GET" class="d-flex align-items-end" style="margin-right: 20px;">
        <input type="hidden" name="page" value="1">
        <div class="me-2">
            <label for="filterBy" class="form-label">Filter By</label>
            <select id="filterBy" name="filter" class="form-select" onchange="updateValueDropdown()" style="width: 200px;">
                <option value="">Select Category</option>
                <option value="course" <?= $selectedCourse ? 'selected' : '' ?>>Course</option>
                <option value="program" <?= $selectedProgram ? 'selected' : '' ?>>Program</option>
            </select>
        </div>
        <div class="me-2">
            <label for="filterValue" class="form-label">Select Value</label>
            <select name="value" class="form-select" id="filterValue" style="width: 200px;">
                <option value="">All Values</option>
                <?php 
                $options = $selectedCourse || !$selectedProgram ? $courses : $programs;
                foreach ($options as $option): ?>
                    <option value="<?= htmlspecialchars($option) ?>" <?= ($selectedCourse == $option || $selectedProgram == $option) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($option) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <?php
    return ob_get_clean(); 
}

// Functions for student management
function addStudent($conn, $studentData) {
    $name = $conn->real_escape_string($studentData['name']);
    $course = $conn->real_escape_string($studentData['course']);
    $program = $conn->real_escape_string($studentData['program']);
    return $conn->query("INSERT INTO studentlist (Student_Name, Course_Name, Program_Year) VALUES ('$name', '$course', '$program')");
}

function editStudent($conn, $studentId, $studentData) {
    $name = $conn->real_escape_string($studentData['name']);
    $course = $conn->real_escape_string($studentData['course']);
    $program = $conn->real_escape_string($studentData['program']);
    return $conn->query("UPDATE studentlist SET Student_Name='$name', Course_Name='$course', Program_Year='$program' WHERE id='$studentId'");
}

function deleteStudent($conn, $studentId) {
    return $conn->query("DELETE FROM studentlist WHERE id='$studentId'");
}
?>
