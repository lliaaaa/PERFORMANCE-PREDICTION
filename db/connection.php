<?php
$servername = "localhost";
$username = "root";
$password = ""; // default is empty in XAMPP
$dbname = "system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>