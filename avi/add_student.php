<?php
session_start();
require_once __DIR__ . '/../db/connection.php';

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit(json_encode(['success' => false, 'message' => 'Unauthorized access']));
}

// Get and validate input
$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['name']) || empty($data['course']) || empty($data['program'])) {
    header('HTTP/1.1 400 Bad Request');
    exit(json_encode(['success' => false, 'message' => 'All fields are required']));
}

// Sanitize inputs
$name = $conn->real_escape_string(trim($data['name']));
$course = $conn->real_escape_string(trim($data['course']));
$program = $conn->real_escape_string(trim($data['program']));

// Start transaction
$conn->begin_transaction();

try {
    // 1. Insert into studentlist
    $stmt1 = $conn->prepare("INSERT INTO studentlist (Student_Name, Course_Name, Program_Year) VALUES (?, ?, ?)");
    $stmt1->bind_param("sss", $name, $course, $program);
    if (!$stmt1->execute()) {
        throw new Exception("Error adding to studentlist: " . $stmt1->error);
    }

    // 2. Insert into records
    $stmt2 = $conn->prepare("INSERT INTO records (Student_Name, Program_Year, Prerequisite_Name) VALUES (?, ?, ?)");
    $stmt2->bind_param("sss", $name, $program, $course);
    if (!$stmt2->execute()) {
        throw new Exception("Error adding to records: " . $stmt2->error);
    }

    // 3. Insert into grades
    $stmt3 = $conn->prepare("INSERT INTO grades (student_name, program_year, course_name) VALUES (?, ?, ?)");
    $stmt3->bind_param("sss", $name, $program, $course);
    if (!$stmt3->execute()) {
        throw new Exception("Error adding to grades: " . $stmt3->error);
    }

    // 4. Insert into report
    $status = "Pending";
    $remarks = "New student added";
    $stmt4 = $conn->prepare("INSERT INTO report (student_name, program_year, course_name, status, remarks) VALUES (?, ?, ?, ?, ?)");
    $stmt4->bind_param("sssss", $name, $program, $course, $status, $remarks);
    if (!$stmt4->execute()) {
        throw new Exception("Error adding to report: " . $stmt4->error);
    }

    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Student added successfully to all tables'
    ]);

} catch (Exception $e) {
    $conn->rollback();
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
