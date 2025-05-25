<?php
// Enhanced error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set custom error log path
ini_set('error_log', __DIR__ . '/logs/php_errors.log');

// Define base paths
define('BASE_PATH', __DIR__);
define('BASE_DIR', '');  // Empty for root-level deployment

// Load configuration
require BASE_PATH . '/includes/config.php';

// Get the clean request path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$request = parse_url($requestUri, PHP_URL_PATH);
$request = rtrim($request, '/'); // Remove trailing slashes

// Debug logging
error_log("\n===== NEW REQUEST =====");
error_log("Time: " . date('Y-m-d H:i:s'));
error_log("Raw URI: $requestUri");
error_log("Processing: $request");

// Handle empty request as home
$request = $request ?: '/';

// Route handling
switch ($request) {
    case '/':
        // Redirect root to scoreboard without loop
        if ($requestUri !== '/scoreboard') {
            error_log("Redirecting / to /scoreboard");
            header('Location: /scoreboard', true, 302);
            exit;
        }
        // Fall through to scoreboard case
    case '/scoreboard':
        error_log("Serving scoreboard");
        require BASE_PATH . '/public/scoreboard.php';
        break;
        
    case '/judges':
        error_log("Serving judge portal");
        require BASE_PATH . '/judges/index.php';
        break;
        
    case '/submit-score':
        error_log("Processing score submission");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require BASE_PATH . '/judges/score.php';
        } else {
            http_response_code(405);
            error_log("405: Invalid method for submit-score");
            die('Method Not Allowed');
        }
        break;
        
    case '/admin':
        error_log("Serving admin panel");
        require BASE_PATH . '/admin/index.php';
        break;
        
    case '/add-judge':
        error_log("Processing judge addition");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require BASE_PATH . '/admin/add_judge.php';
        } else {
            http_response_code(405);
            error_log("405: Invalid method for add-judge");
            die('Method Not Allowed');
        }
        break;
        
    default:
        error_log("404: Not found - $request");
        http_response_code(404);
        die('Page Not Found');
}