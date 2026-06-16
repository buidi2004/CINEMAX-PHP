<?php
// public/index.php

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('VIEW_PATH', ROOT_PATH . '/views');

// Load Composer autoloader if exists
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}

// Custom PSR-4 Autoloader mapping App\ to app/
spl_autoload_register(function (string $class) {
    if (str_starts_with($class, 'App\\')) {
        $relativeClass = substr($class, 4);
        $path = APP_PATH . '/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
});

// Load helper functions
require_once APP_PATH . '/helpers.php';

// Initialize session
App\Core\Session::start();

// Load DI container and router
$container = require_once CONFIG_PATH . '/app.php';
$router    = require_once CONFIG_PATH . '/routes.php';

// Dispatch route with global exception handling
try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (\Throwable $e) {
    http_response_code(500);
    // Display error message (In production, this should be logged and a friendly page shown)
    echo "<h1>500 Internal Server Error</h1>";
    echo "<p>Đã xảy ra lỗi hệ thống. Vui lòng kiểm tra lại cấu hình hoặc liên hệ quản trị viên.</p>";
    
    // Check if we are in local environment or if display_errors is on
    // For now, output the error message to help debug on Render
    echo "<h3>Error Details (for debugging):</h3>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " on line " . $e->getLine() . "</p>";
}
