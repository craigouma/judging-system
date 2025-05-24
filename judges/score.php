<?php
// Enable error reporting and logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');

// Start session for success messages
session_start();

// Log the incoming request
error_log("\n===== SCORE SUBMISSION HANDLER =====");
error_log("Request Time: " . date('Y-m-d H:i:s'));
error_log("Request Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN'));
error_log("POST Data: " . print_r($_POST, true));

require_once __DIR__ . '/../includes/functions.php';

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Error: Invalid request method");
    http_response_code(405);
    $_SESSION['error_message'] = "405 - Method Not Allowed";
    header('Location: /judging-system/judges');
    exit;
}

// Validate required fields
$requiredFields = ['judge_id', 'user_id', 'score'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        $error = "Missing required field: $field";
        error_log("Validation Error: $error");
        $_SESSION['error_message'] = $error;
        header('Location: /judging-system/judges');
        exit;
    }
}

// Sanitize and validate input
$judgeId = (int)$_POST['judge_id'];
$userId = (int)$_POST['user_id'];
$score = (int)$_POST['score'];

error_log("Processing score - Judge: $judgeId, User: $userId, Score: $score");

// Validate score range and IDs
if ($judgeId <= 0 || $userId <= 0) {
    $error = "Invalid judge or participant ID";
    error_log("Validation Error: $error");
    $_SESSION['error_message'] = $error;
    header('Location: /judging-system/judges');
    exit;
}

if ($score < 1 || $score > 100) {
    $error = "Score must be between 1-100";
    error_log("Validation Error: $error");
    $_SESSION['error_message'] = $error;
    header('Location: /judging-system/judges');
    exit;
}

// Process the score submission
try {
    if (addScore($judgeId, $userId, $score)) {
        error_log("Success: Score submitted - Judge: $judgeId, User: $userId, Score: $score");
        $_SESSION['success_message'] = "Score submitted successfully!";
        header('Location: /judging-system/judges');
        exit;
    } else {
        // Check if this is a duplicate submission
        if (scoreExists($judgeId, $userId)) {
            error_log("Notice: Duplicate score submission attempted");
            $_SESSION['error_message'] = "You've already scored this participant";
        } else {
            error_log("Error: Unknown failure in addScore()");
            $_SESSION['error_message'] = "Failed to record score. Please try again.";
        }
        header('Location: /judging-system/judges');
        exit;
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    $_SESSION['error_message'] = "An error occurred: " . $e->getMessage();
    header('Location: /judging-system/judges');
    exit;
}