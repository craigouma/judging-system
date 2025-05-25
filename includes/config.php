<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'judging_user');
define('DB_PASS', 'SecurePassword123!');

define('DB_NAME', 'judging_system');

// Create connection
$conn = new mysqli('localhost', 'judging_user',  'SecurePassword123!', 'judging_system');


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
