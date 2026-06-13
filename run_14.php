<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');

// Load environment variables from .env if it exists
if (file_exists(ROOT_PATH . '/.env')) {
    $lines = file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (strpos($line, '=') === false) continue;
        [$name, $value] = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

require_once ROOT_PATH . '/app/Core/Database.php';

$pdo = App\Core\Database::getInstance();
$sql = file_get_contents(ROOT_PATH . '/migrations/014_extend_admin_modules.sql');
$pdo->exec($sql);
echo 'Migration 014 applied successfully.';
