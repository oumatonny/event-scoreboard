<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: " . (isAdmin() ? '../admin/dashboard.php' : '../judges/dashboard.php'));
    exit();
}

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        // Authenticate user
        global $pdo;
        
        $stmt = $pdo->prepare("SELECT * FROM judges WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Update last login
            $updateStmt = $pdo->prepare("UPDATE judges SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
            $updateStmt->execute([$user['id']]);
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['display_name'] = $user['display_name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            // Redirect to appropriate dashboard
            header("Location: " . ($user['is_admin'] ? '../admin/dashboard.php' : '../judges/dashboard.php'));
            exit();
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Event Scoreboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Scoreboard Login</h1>
            <nav>
                <a href="../">Home</a>
                <a href="register.php">Register</a>
            </nav>
        </header>
        
        <main class="auth-container">
            <div class="card">
                <h2>Please Sign In</h2>
                
                <?php if ($error): ?>
                    <div class="alert error"><?= $error ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn">Login</button>
                </form>
                <div>username : <code>Admin</code> <br> <span>  </span> Password: <code>Admin@123</code> </div>
                <div class="auth-links">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>