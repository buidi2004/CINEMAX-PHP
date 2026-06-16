<?php
// config/database.php

// Helper function to reliably get environment variables in various server environments
$env = function($key, $default = '') {
    $val = getenv($key);
    if ($val !== false && $val !== '') return $val;
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') return $_ENV[$key];
    if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') return $_SERVER[$key];
    return $default;
};

return [
    'driver'   => 'mysql',
    'host'     => $env('DB_HOST', 'localhost'),
    'port'     => $env('DB_PORT', '3306'),
    'dbname'   => $env('DB_NAME', 'cinema_db'),
    'username' => $env('DB_USERNAME', 'root'),
    'password' => $env('DB_PASSWORD', ''),
    'charset'  => 'utf8mb4',
];

