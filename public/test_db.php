<?php
require_once '../includes/config.php';
echo "Testing connection...<br>";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to MySQL!<br>";
    
    // Test if tables exist
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    echo $result->num_rows > 0 ? "Users table exists" : "Users table missing";
    $conn->close();
}
