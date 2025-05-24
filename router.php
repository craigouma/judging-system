<?php
// Enhanced error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set custom error log path - ensure directory exists first
ini_set('error_log', __DIR__ . '/logs/php_errors.log');

// Define base paths
define('BASE_PATH', __DIR__);
define('BASE_DIR', '/judging-system');

// Load configuration
require BASE_PATH . '/includes/config.php';

// Get the clean request path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$request = parse_url($requestUri, PHP_URL_PATH);
$request = rtrim($request, '/'); // Remove trailing slashes

// Debug logging
error_log("\n===== NEW REQUEST ===== " . date('Y-m-d H:i:s'));
error_log("Raw REQUEST_URI: " . $requestUri);
error_log("Initial request path: " . $request);

// Remove base directory from request if present
if (BASE_DIR && strpos($request, BASE_DIR) === 0) {
    $request = substr($request, strlen(BASE_DIR));
    error_log("After base dir removal: " . $request);
}

// Handle empty request as home
$request = $request ?: '/';
error_log("Final processed route: " . $request);
error_log("Request method: " . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN'));

// Route handling
switch ($request) {
    case '/':
    case '/scoreboard':
        error_log("Routing to scoreboard");
        require BASE_PATH . '/public/scoreboard.php';
        break;
        
    case '/judges':
        error_log("Routing to judges portal");
        require BASE_PATH . '/judges/index.php';
        break;
        
    case '/submit-score':
        error_log("Handling score submission");
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            require BASE_PATH . '/judges/score.php';
        } else {
            http_response_code(405);
            error_log("405 Method Not Allowed for submit-score");
            die('405 - Method Not Allowed');
        }
        break;
        
    case '/admin':
        error_log("Routing to admin panel");
        require BASE_PATH . '/admin/index.php';
        break;
        
    case '/add-judge':
        error_log("Handling judge addition");
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            require BASE_PATH . '/admin/add_judge.php';
        } else {
            http_response_code(405);
            error_log("405 Method Not Allowed for add-judge");
            die('405 - Method Not Allowed');
        }
        break;
        
    default:
        error_log("404 Not Found: " . $request);
        http_response_code(404);
        die('404 - Page not found');
}