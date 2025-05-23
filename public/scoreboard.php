<?php 
require_once '../includes/functions.php';

$scoreboard = getScoreboard();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Scoreboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Scoreboard</h1>
            <nav>
                <a href="../">Home</a>
                <a href="../judges/">Judge Portal</a>
            </nav>
        </header>
        
        <main>
            <div class="card">
                <h2>Current Rankings</h2>
                <p>Scores are automatically updated every 10 seconds.</p>
                
                <div id="scoreboard-container">
                    <table id="scoreboard">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Participant</th>
                                <th>Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($scoreboard as $index => $participant): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($participant['name']) ?></td>
                                <td><?= $participant['total_points'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Auto-refresh scoreboard every 10 seconds
        setInterval(function() {
            fetchScoreboard();
        }, 10000);
        
        // Initial load
        document.addEventListener('DOMContentLoaded', fetchScoreboard);
    </script>
</body>
</html>