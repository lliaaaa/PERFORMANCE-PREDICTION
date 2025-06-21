<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container mt-5">
  <div class="text-center">
    <h1 class="mb-3">
      <?php if (isset($_SESSION['full_name'])): ?>
        Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!
      <?php else: ?>
        Welcome to the Student Performance System
      <?php endif; ?>
    </h1>

    <p class="lead">Monitor attendance, grades, participation, and prerequisite records in one place.</p>

    <?php if (isset($_SESSION['user_id'])): ?>
      <p class="mt-4 fs-5">
    <strong>Your User ID:</strong>
    <span id="userIDText"><?php echo $_SESSION['user_id']; ?></span>
    <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyUserID()" title="Copy">
      📋
    </button>
  </p>
  <p id="copySuccess" class="text-success" style="display:none;">Copied!</p>

      <p class="text-danger">Your User ID will be used for your login.</p>
    <?php else: ?>
      <p class="text-danger">User not logged in.</p>
    <?php endif; ?>

    <div class="d-grid gap-2 col-md-4 mx-auto mt-3">
      <a style="background-color: #8B0000" href="index.php?page=dashboard" class="btn btn-primary btn-lg">Go to Dashboard</a>
    </div>
  </div>
</div>
<script>
  function copyUserID() {
    const text = document.getElementById("userIDText").innerText;
    navigator.clipboard.writeText(text).then(() => {
      const msg = document.getElementById("copySuccess");
      msg.style.display = "inline";
      setTimeout(() => {
        msg.style.display = "none";
      }, 2000);
    });
  }
</script>

