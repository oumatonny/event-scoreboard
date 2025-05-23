<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Scoreboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Scoreboard System</h1>
            <div class="logo">ES</div>
        </header>
        
        <main>
            <div class="card">
                <h2>Welcome to the Event Scoreboard</h2>
                <p>Please select your role:</p>
                
                <div class="role-buttons">
                    <a href="public/scoreboard.php" class="btn">View Scoreboard</a>
                    <a href="auth/login.php" class="btn">Admin</a>
                    <a href="auth/register.php" class="btn admin-btn">Register as Admin/Judge</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>