<?php
require_once 'db.php';

// Get all users
function getAllUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all judges
function getAllJudges() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM judges ORDER BY display_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Add new judge
function addJudge($username, $displayName, $password, $isAdmin = false) {
    global $pdo;
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO judges (username, display_name, password_hash, is_admin) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$username, $displayName, $passwordHash, $isAdmin]);
}

// Add score for user from judge
function addScore($judgeId, $userId, $points) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO scores (judge_id, user_id, points) VALUES (?, ?, ?)");
    return $stmt->execute([$judgeId, $userId, $points]);
}

// Get scoreboard data
function getScoreboard() {
    global $pdo;
    $sql = "SELECT u.id, u.name, COALESCE(SUM(s.points), 0) AS total_points
            FROM users u
            LEFT JOIN scores s ON u.id = s.user_id
            GROUP BY u.id, u.name
            ORDER BY total_points DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get scores by judge
function getScoresByJudge($judgeId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT user_id, points FROM scores WHERE judge_id = ?");
    $stmt->execute([$judgeId]);
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

// Get total number of scores
function getTotalScores() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM scores");
    return $stmt->fetchColumn();
}

// Display recent activity
function displayRecentActivity() {
    global $pdo;
    $sql = "SELECT j.display_name AS judge, u.name AS participant, s.points, s.created_at
            FROM scores s
            JOIN judges j ON s.judge_id = j.id
            JOIN users u ON s.user_id = u.id
            ORDER BY s.created_at DESC
            LIMIT 5";
    $stmt = $pdo->query($sql);
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($activities)) {
        echo "<p>No recent activity found.</p>";
        return;
    }
    
    echo "<table><thead><tr><th>Judge</th><th>Participant</th><th>Points</th><th>Time</th></tr></thead><tbody>";
    foreach ($activities as $activity) {
        echo "<tr>
                <td>{$activity['judge']}</td>
                <td>{$activity['participant']}</td>
                <td>{$activity['points']}</td>
                <td>" . date('M j, H:i', strtotime($activity['created_at'])) . "</td>
              </tr>";
    }
    echo "</tbody></table>";
}
?>