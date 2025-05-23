<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $displayName = $_POST['display_name'] ?? '';
    
    if (!empty($username) && !empty($displayName)) {
        if (addJudge($username, $displayName)) {
            header('Location: index.php?success=1');
            exit;
        } else {
            $error = "Failed to add judge. Username might already exist.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}

// If we get here, there was an error
header('Location: index.php?error=' . urlencode($error ?? 'Unknown error'));
exit;
?>