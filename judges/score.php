<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judgeId = (int)$_POST['judge_id'];
    $userId = (int)$_POST['user_id'];
    $score = (int)$_POST['score'];
    
    if ($judgeId > 0 && $userId > 0 && $score >= 1 && $score <= 100) {
        if (addScore($judgeId, $userId, $score)) {
            header('Location: /judging-system/judges?success=1');
            exit;
        } else {
            $error = "Failed to add score. You may have already scored this participant.";
        }
    } else {
        $error = "Invalid score data. Score must be between 1-100.";
    }
}

// If we get here, there was an error
header('Location: /judging-system/judges?error=' . urlencode($error ?? 'Unknown error'));
exit;
?>