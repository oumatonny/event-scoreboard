<?php
require_once '../includes/auth.php';
requireAuth();

$judgeId = $_SESSION['user_id'];
$users = getAllUsers();
$scores = getScoresByJudge($judgeId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Dashboard - Event Scoreboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Judge Dashboard</h1>
            <nav>
                <span>Welcome, <?= htmlspecialchars($_SESSION['display_name']) ?></span>
                <a href="../public/scoreboard.php">View Scoreboard</a>
                <a href="../auth/logout.php">Logout</a>
            </nav>
        </header>
        
        <div class="judge-info">
            <h2>Scoring Panel</h2>
            <p>Select a participant below to assign scores.</p>
        </div>
        
        <main>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert success">Score submitted successfully!</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert error"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            
            <div class="card">
                <h2>Participants</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th>Your Previous Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= $scores[$user['id']] ?? 'Not scored yet' ?></td>
                            <td>
                                <form method="POST" action="submit_score.php" class="score-form">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="number" name="points" min="1" max="100" required 
                                           placeholder="1-100" class="score-input">
                                    <button type="submit" class="btn">Submit</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>