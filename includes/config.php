<?php
define('DB_HOST', 'db');
define('DB_USER', 'judging_user');
define('DB_PASS', 'SecurePassword123!');

define('DB_NAME', 'judging_system');

// Create connection
$conn = new mysqli('db', 'judging_user',  'SecurePassword123!', 'judging_system', 3306);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
