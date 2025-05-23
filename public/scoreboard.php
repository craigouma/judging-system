<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Competition Scoreboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .highlight { background-color: #ffff99; }
        .top3 { background-color: #e6f7ff; }
    </style>
</head>
<body>
    <h1>Competition Scoreboard</h1>
    
    <div id="scoreboard">
        <table>
            <tr>
                <th>Rank</th>
                <th>Participant</th>
                <th>Total Score</th>
            </tr>
            <?php 
            $scores = getScores();
            $rank = 0;
            foreach ($scores as $score): 
                $rank++;
                $highlightClass = $rank <= 3 ? 'top3' : '';
                $highlightClass = $score['total_score'] === null ? '' : $highlightClass;
            ?>
            <tr class="<?= $highlightClass ?>">
                <td><?= $rank ?></td>
                <td><?= htmlspecialchars($score['user_name']) ?></td>
                <td><?= $score['total_score'] ?? '0' ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
    <script>
        // Auto-refresh every 10 seconds
        setTimeout(function() {
            location.reload();
        }, 10000);
    </script>
</body>
</html>