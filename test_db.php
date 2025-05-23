<?php
require 'includes/config.php';
echo $conn ? "Connected!" : "Failed!";
$conn->close();
