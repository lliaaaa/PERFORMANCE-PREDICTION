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

  <style>
    body {
      margin: 0;
      padding-top: 80px; /* Space for fixed navbar */
      padding-bottom: 70px; /* Space for fixed footer if any */
      background-color: #f2f2f2;
    }

    .navbar {
      background-color: #8B0000;
      color: white;
      padding: 20px 0;
    }

    .nav-left {
      display: flex;
      align-items: center;
    }

    .menu-toggle {
      background: none;
      border: none;
      cursor: pointer;
      margin-right: 20px;
    }

    .brand {
      font-weight: bold;
      font-size: 22px;
      color: white;
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav-icon svg {
      stroke: white;
      transition: transform 0.2s ease;
    }

    .nav-icon:hover svg {
      transform: scale(1.1);
    }

    /* Sidebar styles */
    .sidebar {
      position: fixed;
      top: 60px; /* Match navbar height */
      left: -250px;
      width: 190px;
      height: 100%;
      background-color: #8B0000;
      color: white;
      padding-top: 20px;
      transition: left 0.3s ease;
      z-index: 999;
    }

    .sidebar.open {
      left: 0;
    }

    .sidebar-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar-links li {
      margin: 5px 15px;
    }

    .sidebar-links a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      display: block;
      padding: 10px 0;
      transition: background 0.2s;
      text-align: center;
    }

    .sidebar-links a:hover {
      background-color: #f4f4f4;
      color: #8B0000;
      width: 175px;
      margin-left: -5px;
    }
  </style>
</head>
<body>

   <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <ul class="sidebar-links">
      <li><a href="index.php?page=home">Home</a></li>
      <li><a href="index.php?page=dashboard">Dashboard</a></li> <!-- ✅ Dashboard inserted after Home -->
      <li><a href="index.php?page=studentlist">Student List</a></li>
      <li><a href="index.php?page=attendance">Attendance</a></li>
      <li><a href="index.php?page=participation">Participation</a></li>
      <li><a href="index.php?page=grades">Grades</a></li>
      <li><a href="index.php?page=report">Report</a></li>
      <!-- Add more links as needed -->
    </ul>
  </div>


  <!-- Navbar -->
  <nav class="navbar fixed-top">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="nav-left">
        <!-- Hamburger -->
        <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="18" x2="21" y2="18" />
          </svg>
        </button>
        <span class="brand">Class Performance Prediction System</span>
      </div>

      <div class="nav-right">
        <!-- Settings Icon -->
        <a href="settings.html" title="Settings" class="nav-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33
                     1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51
                     1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06
                     a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09
                     a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06
                     a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.06
                     a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51
                     h.06a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06
                     a1.65 1.65 0 0 0-.33 1.82v.06a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09
                     a1.65 1.65 0 0 0-1.51 1z"/>
          </svg>
        </a>
        <!-- Profile Icon with Dropdown -->
    <div class="profile-wrapper" style="position: relative;">
      <div class="nav-icon profile-icon" id="profileIcon">
        <!-- 👤 SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" stroke="white" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="7" r="4"></circle>
          <path d="M5.5 21a9.5 9.5 0 0 1 13 0"></path>
        </svg>
      </div>

      <div class="dropdown" id="dropdownMenu" style="display: none; position: absolute; top: calc(100% + 15px); left: 50%; transform: translateX(-50%); background-color: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 1000; width: 180px;">

        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="index.php?page=profile" style="display: block; padding: 10px 15px; text-decoration: none; color: black;">Profile</a>
          <a href="index.php?page=login" style="display: block; padding: 10px 15px; text-decoration: none; color: black;">Logout</a>
        <?php else: ?>
          <a href="index.php?page=login" style="display: block; padding: 10px 15px; text-decoration: none; color: black;">Log in</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  </nav>

  <!-- Main Content Area -->
  <div class="container mt-4">
    <!-- Page content goes here -->
  </div>

  <!-- Toggle Sidebar Script -->
  <script>
    document.getElementById("menuToggle").addEventListener("click", function () {
      document.getElementById("sidebar").classList.toggle("open");
    });
    const profileIcon = document.getElementById('profileIcon');
    const dropdownMenu = document.getElementById('dropdownMenu');

    profileIcon.addEventListener('click', function (e) {
      e.stopPropagation();
      dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function (e) {
      if (!dropdownMenu.contains(e.target)) {
        dropdownMenu.style.display = 'none';
      }
    });
  </script>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
