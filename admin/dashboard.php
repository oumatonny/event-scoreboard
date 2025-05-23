<?php
require_once '../includes/auth.php';
requireAdmin();

$judges = getAllJudges();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Event Scoreboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Dashboard</h1>
            <nav>
                <span>Welcome, <?= htmlspecialchars($_SESSION['display_name']) ?></span>
                <a href="../judges">Judges Portal</a>
                <a href="../judges/scoreboard.php">View Scoreboard</a>
                <a href="../auth/logout.php">Logout</a>
            </nav>
        </header>
        
        <main>
            <div class="card">
                <h2>System Overview</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Judges</h3>
                        <p><?= count($judges) ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Total Participants</h3>
                        <p><?= count(getAllUsers()) ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Total Scores Recorded</h3>
                        <p><?= getTotalScores() ?></p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h2>Recent Activity</h2>
                <?php displayRecentActivity(); ?>
            </div>
        </main>
    </div>
</body>
</html>