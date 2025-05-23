<?php require_once '../includes/functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Judge Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin: 20px 0; padding: 20px; border: 1px solid #ddd; }
        input, button { padding: 8px; margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Judge Management</h1>
    
    <h2>Add New Judge</h2>
    <form action="add_judge.php" method="post">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Display Name: <input type="text" name="display_name" required></label><br>
        <button type="submit">Add Judge</button>
    </form>
    
    <h2>Existing Judges</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Display Name</th>
        </tr>
        <?php foreach (getJudges() as $judge): ?>
        <tr>
            <td><?= $judge['id'] ?></td>
            <td><?= htmlspecialchars($judge['username']) ?></td>
            <td><?= htmlspecialchars($judge['display_name']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>