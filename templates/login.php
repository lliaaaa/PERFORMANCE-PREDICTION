<style>
  .login-container {
    max-width: 400px;
    width: 100%;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 30px;
  }
  .brand-title {
    font-weight: bold;
    font-size: 2rem;
    color: black;
  }
  .btn-custom {
    background-color: #8B0000;
    color: #fff;
    border: none;
  }
  .btn-custom:hover {
    background-color: rgb(171, 55, 55);
  }
</style>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
  <div class="signup-container text-center p-4 rounded shadow bg-white" style="max-width: 400px;height:110%; width: 100%;">
    <h2 class="brand-title mb-5">Login</h2>
    <form action="handlers/login.php" method="post">
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
      <?php endif; ?>
      <div class="form-floating mb-3 text-start">
        <input type="text" class="form-control" name="userid" id="userid" placeholder="User ID" required>
        <label for="userid">User ID</label>
      </div>
      <div class="form-floating mb-4 text-start">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
        <label for="password">Password</label>
      </div>
      <button type="submit" class="btn btn-custom w-100">Login</button>
      <p class="mt-3">Don't have an account? <a href="index.php?page=signup">Sign up here</a></p>
    </form>
  </div>
</div>
