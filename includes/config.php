<?php
$host = getenv('DB_HOST') ?: 'localhost';
$db = getenv('DB_NAME') ?: 'judging_system';
$user = getenv('DB_USER') ?: 'judging_user';
$pass = getenv('DB_PASS') ?: 'SecurePassword123!';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
