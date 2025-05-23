<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', __DIR__);
require BASE_PATH . '/includes/config.php';

// Get the request URI and remove query parameters
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base directory from the request path
$baseDir = '/judging-system'; // Your base directory
if (strpos($request, $baseDir) === 0) {
    $request = substr($request, strlen($baseDir));
}
$request = $request ?: '/';

switch ($request) {
    case '/':
    case '/scoreboard':
        require BASE_PATH . '/public/scoreboard.php';
        break;
    case '/admin':
        require BASE_PATH . '/admin/index.php';
        break;
    case '/judges':
        require BASE_PATH . '/judges/index.php';
        break;
    case '/submit-score':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require BASE_PATH . '/judges/score.php';
        } else {
            http_response_code(405);
            echo '405 - Method Not Allowed';
        }
        break;
    case '/add-judge':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require BASE_PATH . '/admin/add_judge.php';
        } else {
            http_response_code(405);
            echo '405 - Method Not Allowed';
        }
        break;
    default:
        http_response_code(404);
        echo '404 - Page not found';
}
?>