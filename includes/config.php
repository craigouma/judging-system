<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'judging_user');
define('DB_PASS', 'SecurePassword123!');
define('DB_NAME', 'judging_system');

// Use the correct socket path found in your system
$conn = new mysqli(
    'localhost',                // host
    DB_USER,                    // username
    DB_PASS,                    // password
    DB_NAME,                    // database
    null,                       // port (null for socket)
    '/run/mysqld/mysqld.sock'   // CORRECT socket path
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>