<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Class Performance Prediction System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
</head>
<body>

   <!-- Sidebar -->
   <?php renderSidebar($page); ?>

  <!-- Navbar -->
  <nav class="navbar fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="nav-left">
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="18" x2="21" y2="18" />
          </svg>
        </button>
        <span class="brand">Class Performance Prediction System</span>
      </div>
      <div class="profile-wrapper" style="position: relative;">
        <div class="nav-icon profile-icon" id="profileIcon">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" stroke="white" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="7" r="4"></circle>
            <path d="M5.5 21a9.5 9.5 0 0 1 13 0"></path>
          </svg>
        </div>
        <div class="dropdown" id="dropdownMenu" style="display: none;">
          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?page=profile">Profile</a>
            <a href="templates/logout.php">Logout</a>
          <?php else: ?>
            <a href="index.php?page=login">Log in</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content Area -->
  <div class="container mt-4">
    <!-- Page content goes here -->
  </div>

  <script src="js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
function renderSidebar($activePage) {
    $pages = ['home', 'dashboard', 'studentlist', 'activities', 'records', 'report'];
    echo '<div class="sidebar" id="sidebar"><ul class="sidebar-links">';
    foreach ($pages as $page) {
        $activeClass = ($activePage === $page) ? 'active' : '';
        echo "<li class='$activeClass'><a href='index.php?page=$page'>".ucfirst($page)."</a></li>";
    }
    echo '</ul></div>';
}
?>
