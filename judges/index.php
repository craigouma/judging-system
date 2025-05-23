<?php 
require_once __DIR__ . '/../includes/functions.php';

// For demo purposes, we'll use judge_id=1
// In a real app, this would come from authentication
$judgeId = 1;
$judge = current(array_filter(getJudges(), function($j) use ($judgeId) {
    return $j['id'] == $judgeId;
}));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Judge Portal - <?= htmlspecialchars($judge['display_name']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { display: inline; }
        input[type="number"] { width: 60px; }
    </style>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($judge['display_name']) ?></h1>
    
    <h2>Participants</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <?php foreach (getUnscoredUsers($judgeId) as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td>
                <form action="/judging-system/submit-score" method="post">
                    <input type="hidden" name="judge_id" value="<?= $judgeId ?>">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <input type="number" name="score" min="1" max="100" required>
                    <button type="submit">Submit Score</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>