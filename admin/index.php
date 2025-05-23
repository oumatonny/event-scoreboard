<?php 
require_once '../includes/functions.php';

// Handling form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_judge'])) {
        $username = trim($_POST['username']);
        $displayName = trim($_POST['display_name']);
        
        if (!empty($username) && !empty($displayName)) {
            if (addJudge($username, $displayName)) {
                $success = "Judge added successfully!";
            } else {
                $error = "Failed to add judge. Username might already exist.";
            }
        } else {
            $error = "Please fill all fields.";
        }
    }
}

$judges = getAllJudges();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Judge Management</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel - Judge Management</h1>
            <nav>
                <a href="../">Home</a>
                <a href="../judges">Manage Judges</a>
            </nav>
        </header>
        
        <main>
            <div class="card">
                <h2>Add New Judge</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert error"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert success"><?= $success ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="display_name">Display Name:</label>
                        <input type="text" id="display_name" name="display_name" required>
                    </div>
                    
                    <button type="submit" name="add_judge" class="btn">Add Judge</button>
                </form>
            </div>
            
            <div class="card">
                <h2>Current Judges</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Display Name</th>
                            <th>Added On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($judges as $judge): ?>
                        <tr>
                            <td><?= $judge['id'] ?></td>
                            <td><?= htmlspecialchars($judge['username']) ?></td>
                            <td><?= htmlspecialchars($judge['display_name']) ?></td>
                            <td><?= date('M j, Y', strtotime($judge['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>