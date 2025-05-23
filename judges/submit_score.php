<?php
require_once '../includes/auth.php';
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judgeId = $_SESSION['user_id'];
    $userId = (int)$_POST['user_id'];
    $points = (int)$_POST['points'];
    
    if ($points >= 1 && $points <= 100) {
        if (addScore($judgeId, $userId, $points)) {
            header("Location: dashboard.php?success=1");
            exit();
        } else {
            header("Location: dashboard.php?error=Failed to submit score");
            exit();
        }
    } else {
        header("Location: dashboard.php?error=Points must be between 1 and 100");
        exit();
    }
}

header("Location: dashboard.php");
exit();
?>