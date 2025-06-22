<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../db/connection.php'; // Use absolute path
require_once __DIR__ . '/../functions.php';

// Get selected filter and value from the request
$selectedPrerequisite = $_GET['prerequisite'] ?? '';
$selectedProgram = $_GET['program'] ?? ''; // Added to handle program selection

// Get all prerequisites and programs
$prerequisites = getPrerequisites($conn); // Fetch prerequisites from the database
$programs = getPrograms($conn); // Fetch programs from the database

// Fetch records based on the selected prerequisite and program
$grades = [];
$query = "SELECT Student_Name, Program_Year, Prerequisite_Name, Prerequisite_Attendance, Prerequisite_Percentage, Prerequisite_Grade 
          FROM records 
          WHERE 1=1"; // Start with a base query

// Add filters to the query
if ($selectedPrerequisite) {
    $query .= " AND Prerequisite_Name = ?";
}
if ($selectedProgram) {
    $query .= " AND Program_Year = ?";
}

$stmt = $conn->prepare($query);

// Bind parameters based on which filters are applied
if ($selectedPrerequisite && $selectedProgram) {
    $stmt->bind_param("ss", $selectedPrerequisite, $selectedProgram);
} elseif ($selectedPrerequisite) {
    $stmt->bind_param("s", $selectedPrerequisite);
} elseif ($selectedProgram) {
    $stmt->bind_param("s", $selectedProgram);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $grades[] = [
        'name' => $row['Student_Name'],
        'program' => $row['Program_Year'],
        'prerequisite' => $row['Prerequisite_Name'],
        'attendance' => $row['Prerequisite_Attendance'] ?: '', // Default to '' if empty
        'percentage' => $row['Prerequisite_Percentage'] ?: 0, // Default to 0 if empty
        'grade' => $row['Prerequisite_Grade'] ?: '' // Default to '' if empty
    ];
}
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Records</h2>
        <div class="display-flex">
            <!-- Prerequisite and Program Filter -->
            <form method="GET" class="mb-3" id="filterForm" onsubmit="return handleFilterSubmit(event);">
                <div class="d-flex align-items-center">
                    <select style="width: 150%" name="prerequisite" class="form-select" id="prerequisiteSelect">
                        <option value="">Select Prerequisite</option>
                        <?php foreach ($prerequisites as $prerequisite): ?>
                            <option value="<?= htmlspecialchars($prerequisite) ?>" <?= $selectedPrerequisite === $prerequisite ? 'selected' : '' ?>>
                                <?= htmlspecialchars($prerequisite) ?>
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

    <!-- Records Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Prerequisite</th>
                    <th>Program</th>
                    <th>Attendance</th>
                    <th>Percentage</th>
                    <th>Grade</th>
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
                            <td class="p-1"><?= htmlspecialchars($grade['prerequisite']) ?></td>
                            <td class="p-1"><?= htmlspecialchars($grade['program']) ?></td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($grade['attendance']) ?></td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($grade['percentage']) ?>%</td>
                            <td style="text-align: center" class="p-1"><?= htmlspecialchars($grade['grade']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No records available for this prerequisite.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
let isEditing = false; // Track the editing state

function toggleActionButtons() {
    const actionButtons = document.getElementById('actionButtons');
    const updateButton = document.getElementById('updateButton');

    if (actionButtons.style.display === 'none' || actionButtons.style.display === '') {
        actionButtons.style.display = 'block'; // Show buttons
        updateButton.textContent = 'Save Changes'; // Change button text
        isEditing = true; // Set editing state
    } else {
        actionButtons.style.display = 'none'; // Hide buttons
        updateButton.textContent = 'Update Content'; // Revert button text
        isEditing = false; // Reset editing state
    }
}

function addStudent() {
    // Example data to send; replace with actual data as needed
    const studentData = {
        name: 'New Student',
        course: 'Course Name',
        program: 'Program Year'
    };

    fetch('add_student.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(studentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Student added successfully!');
            location.reload(); // Reload the page to see the updated list
        } else {
            alert('Error adding student: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function editStudent() {
    // Example data to send; replace with actual data as needed
    const studentId = 1; // Replace with the actual student ID
    const studentData = {
        name: 'Updated Student',
        course: 'Updated Course',
        program: 'Updated Program'
    };

    fetch('edit_student.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: studentId, data: studentData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Student edited successfully!');
            location.reload(); // Reload the page to see the updated list
        } else {
            alert('Error editing student: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteStudent() {
    const studentId = 1; // Replace with the actual student ID

    if (confirm('Are you sure you want to delete this student?')) {
        fetch('delete_student.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: studentId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Student deleted successfully!');
                location.reload(); // Reload the page to see the updated list
            } else {
                alert('Error deleting student: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function handleFilterSubmit(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get selected values
    const prerequisite = document.getElementById('prerequisiteSelect').value;
    const program = document.getElementById('programSelect').value; // Added to handle program selection

    // Call the filterAction function with selected values
    filterAction(prerequisite, program);
}

function filterAction(prerequisite, program) {
    let url = 'http://localhost/SYSTEM/index.php?page=records';

    // Check if prerequisite is selected
    if (prerequisite) {
        url += '&prerequisite=' + encodeURIComponent(prerequisite);
    }

    // Check if program is selected
    if (program) {
        url += '&program=' + encodeURIComponent(program);
    }

    // Redirect to the constructed URL
    window.location.href = url;
}
</script>
