<?php 
require_once '../includes/functions.php';

// Simulate judge login (in a real app, this would be proper authentication)
$judgeId = isset($_GET['judge_id']) ? (int)$_GET['judge_id'] : 1;

// Handle score submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_score'])) {
    $userId = (int)$_POST['user_id'];
    $points = (int)$_POST['points'];
    
    if ($points >= 1 && $points <= 100) {
        if (addScore($judgeId, $userId, $points)) {
            $success = "Score submitted successfully!";
        } else {
            $error = "Failed to submit score.";
        }
    } else {
        $error = "Points must be between 1 and 100.";
    }
}

$users = getAllUsers();
$scores = getScoresByJudge($judgeId);
$judges = getAllJudges();
$currentJudge = array_filter($judges, function($j) use ($judgeId) {
    return $j['id'] == $judgeId;
});
$currentJudge = reset($currentJudge);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Judge Portal</h1>
            <nav>
                <a href="../">Home</a>
                <a href="../public/scoreboard.php">View Scoreboard</a>
            </nav>
        </header>
        
        <div class="judge-info">
            <h2>Welcome, <?= htmlspecialchars($currentJudge['display_name']) ?></h2>
            <p>Select a participant below to assign scores.</p>
        </div>
        
        <main>
            <?php if (isset($error)): ?>
                <div class="alert error"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert success"><?= $success ?></div>
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
                                <form method="POST" class="score-form">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="number" name="points" min="1" max="100" required 
                                           placeholder="1-100" class="score-input">
                                    <button type="submit" name="submit_score" class="btn">Submit</button>
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