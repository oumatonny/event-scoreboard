<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: " . (isAdmin() ? '../admin/dashboard.php' : '../judges/dashboard.php'));
    exit();
}

$errors = [];
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $displayName = trim($_POST['display_name']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $isAdmin = isset($_POST['is_admin']) ? true : false;
    
    // Validate inputs
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['username'] = 'Username can only contain letters, numbers and underscores';
    }
    
    if (empty($displayName)) {
        $errors['display_name'] = 'Display name is required';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    // If no errors, try to register
    if (empty($errors)) {
        global $pdo;
        
        try {
            // Check if username exists
            $stmt = $pdo->prepare("SELECT id FROM judges WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->fetch()) {
                $errors['username'] = 'Username already exists';
            } else {
                // Create new account
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO judges (username, display_name, password_hash, is_admin) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $displayName, $passwordHash, $isAdmin]);
                
                $success = 'Account created successfully! You can now login.';
                $_POST = []; // Clear form
            }
        } catch (PDOException $e) {
            $errors['database'] = 'Registration failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Event Scoreboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Scoreboard Registration</h1>
            <nav>
                <a href="../">Home</a>
                <a href="login.php">Login</a>
            </nav>
        </header>
        
        <main class="auth-container">
            <div class="card">
                <h2>Create New Account</h2>
                
                <?php if ($success): ?>
                    <div class="alert success"><?= $success ?></div>
                <?php endif; ?>
                
                <?php if (isset($errors['database'])): ?>
                    <div class="alert error"><?= $errors['database'] ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" 
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                        <?php if (isset($errors['username'])): ?>
                            <span class="error-text"><?= $errors['username'] ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="display_name">Display Name:</label>
                        <input type="text" id="display_name" name="display_name" 
                               value="<?= htmlspecialchars($_POST['display_name'] ?? '') ?>" required>
                        <?php if (isset($errors['display_name'])): ?>
                            <span class="error-text"><?= $errors['display_name'] ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <?php if (isset($errors['password'])): ?>
                            <span class="error-text"><?= $errors['password'] ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <?php if (isset($errors['confirm_password'])): ?>
                            <span class="error-text"><?= $errors['confirm_password'] ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="is_admin" name="is_admin" 
                               <?= isset($_POST['is_admin']) ? 'checked' : '' ?>>
                        <label for="is_admin">Register as Administrator</label>
                    </div>
                    
                    <button type="submit" class="btn">Register</button>
                </form>
                
                <div class="auth-links">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>