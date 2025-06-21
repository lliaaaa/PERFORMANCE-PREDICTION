<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Display all session variables
echo '<div class="debug-info alert alert-warning" style="display: none;">';
echo '<pre>Session Data: ';
print_r($_SESSION);
echo '</pre>';
echo '</div>';
?>
<div class="container col-md-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Profile</h2>
    </div>
    <div class="row justify-content-center">
        <div>
            <div class="card p-3 shadow-sm">
                <h5 class="card-title mb-3">Account Details</h5>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User ID -->
                    <p><strong>User ID:</strong> <br>
                        <?php echo htmlspecialchars($_SESSION['user_id'] ?? 'Not available'); ?>
                    </p>
                    
                    <!-- Full Name -->
                    <p><strong>Full Name:</strong> <br>
                        <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Not available'); ?>
                    </p>
                    
                    <div class="mb-3">
                        <p><strong>Email Address:</strong>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>No user data available. Please log in.</p>
                        <a href="login.php" class="btn btn-sm btn-primary mt-2">Login Now</a>
                    </div>
                <?php endif; ?>
                
                <button style="background-color: #8B0000" type="submit" class="btn btn-primary w-100">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
// Simple jQuery to toggle debug info visibility
document.querySelector('.toggle-debug').addEventListener('click', function() {
    const debugInfo = document.querySelector('.debug-info');
    debugInfo.style.display = debugInfo.style.display === 'none' ? 'block' : 'none';
    this.textContent = debugInfo.style.display === 'none' ? 'Show Debug Info' : 'Hide Debug Info';
});
</script>
