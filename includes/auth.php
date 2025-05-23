<?php
require_once 'functions.php';

// Starting session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Checking if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Checking if user is admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

// Authenticating user
function authenticate($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM judges WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        // Updatting last login
        $updateStmt = $pdo->prepare("UPDATE judges SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
        $updateStmt->execute([$user['id']]);
        
        // Setting session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['display_name'] = $user['display_name'];
        $_SESSION['is_admin'] = $user['is_admin'];
        
        return true;
    }
    
    return false;
}

// Logout user
function logout() {
    $_SESSION = array();
    session_destroy();
}

// Redirecting if not authenticated
function requireAuth() {
    if (!isLoggedIn()) {
        header("Location: ../auth/login.php");
        exit();
    }
}

// Redirecting if not admin
function requireAdmin() {
    requireAuth();
    if (!isAdmin()) {
        header("Location: ../judges/dashboard.php");
        exit();
    }
}
?>