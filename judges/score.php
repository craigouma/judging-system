<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judgeId = $_POST['judge_id'] ?? 0;
    $userId = $_POST['user_id'] ?? 0;
    $score = $_POST['score'] ?? 0;
    
    if ($judgeId > 0 && $userId > 0 && $score >= 1 && $score <= 100) {
        if (addScore($judgeId, $userId, $score)) {
            header('Location: index.php?success=1');
            exit;
        } else {
            $error = "Failed to add score. You may have already scored this participant.";
        }
    } else {
        $error = "Invalid score data.";
    }
}

// If we get here, there was an error
header('Location: index.php?error=' . urlencode($error ?? 'Unknown error'));
exit;
?>