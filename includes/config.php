<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'judging_user');
define('DB_PASS', 'SecurePassword123!');

define('DB_NAME', 'judging_system');

// Create connection
//$conn = new mysqli('localhost', 'judging_user',  'SecurePassword123!', 'judging_system');
// Create connection with explicit socket path
$conn = new mysqli(
    'localhost',          // host
    DB_USER,              // username
    DB_PASS,              // password
    DB_NAME,              // database
    3306,                 // port - explicitly set
    '/var/run/mysqld/mysqld.sock'  // socket path
);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
