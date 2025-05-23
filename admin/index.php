<?php require_once __DIR__ . '/../includes/functions.php'; ?>
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
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-success { background-color: #dff0d8; color: #3c763d; }
        .alert-error { background-color: #f2dede; color: #a94442; }
    </style>
</head>
<body>
    <h1>Judge Management</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Judge added successfully!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    
    <h2>Add New Judge</h2>
    <form action="/judging-system/add-judge" method="post">
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