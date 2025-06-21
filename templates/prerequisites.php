<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include connection first
require_once __DIR__ . '/../db/connection.php'; // Use absolute path
// Then include functions
require_once __DIR__ . '/../functions.php';

// Get all prerequisites
$prerequisites = getPrerequisites($conn);

// Debugging: Check if courses are retrieved
if (empty($prerequisites)) {
    echo "<p>No prerequisites available.</p>";
    exit();
}
?>
<style>
    .btn-red {
        background-color: #8B0000; /* Set the background color to dark red */
        color: white; /* Set the text color to white for better contrast */
        padding: 20px 35px; /* Increase button size */
        border-radius: 5px; /* Round corners */
        font-size: 1.2rem; /* Increase font size */
        margin-bottom: 1rem; /* Space between each button */
        border: none; /* Remove border for button */
        cursor: pointer; /* Change cursor to pointer */
    }

    .btn-red:hover {
        background-color: #A52A2A; /* Lighter red on hover */
    }
    .full-height {
        height: 40vh; /* Full viewport height */
    }
</style>

<div style="margin-top: 3%">
    <h3 class="mb-4 text-center">Select a Prerequisite to View</h3> <!-- Centered heading -->
</div>
<div class="container d-flex align-items-center justify-content-center full-height"> <!-- Centering container -->
    <div>
        <div class="btn-group-vertical" role="group" aria-label="Prerequisite selection">
            <?php foreach ($prerequisites as $prerequisite): ?>
                <button class="btn btn-red" onclick="location.href='index.php?page=grades&course=<?= urlencode($prerequisite) ?>'">
                    <?= htmlspecialchars($prerequisite) ?>
                </button>
            <?php endforeach; ?>
        </div>

    </div>
</div>
