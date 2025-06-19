<?php
$useBootstrapIcons = false; // Not needed here
?>

<style>
  body.login-body {
    background-color: #f8f9fa;
  }

  .form-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 75vh;
  }

  .form-container {
    width: 28%;
    padding: 2.5rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
  }

  .brand-title {
    color: black;
    font-size: 2rem;
    font-weight: 600;
  }

  .btn-custom {
    background-color: #8B0000;
    color: white;
    border: none;
  }

  .btn-custom:hover {
    background-color: #a30000;
  }

  .form-floating label {
    font-size: 0.9rem;
  }
</style>
  <div class="form-wrapper">
    <div class="form-container text-center">
      <h2 class="brand-title mb-3">Sign Up</h2>
      <form action="handlers/signup.php" method="post">
        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger">
            <?= htmlspecialchars($_GET['error']) ?>
          </div>
        <?php endif; ?>

        <div class="form-floating mb-3 text-start">
          <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" required>

          <label for="fullname">Full Name</label>
        </div>

        <div class="form-floating mb-3 text-start">
          <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
          <label for="email">Email</label>
        </div>

        <div class="form-floating mb-3 text-start">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <label for="password">Password</label>
        </div>
        <button type="submit" name="submit" class="btn btn-custom w-100">Register</button>
        <p class="mt-3">Already have an account? <a href="index.php?page=login">Login here</a></p>
      </form>
    </div>
  </div>
