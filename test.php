<?php
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('VIEW_PATH', ROOT_PATH . '/views');

spl_autoload_register(function (string $class) {
    if (str_starts_with($class, 'App\\')) {
        $relativeClass = substr($class, 4);
        $path = APP_PATH . '/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
});
require_once APP_PATH . '/helpers.php';
App\Core\Session::start();
$container = require_once CONFIG_PATH . '/app.php';

$users = $container->make(\App\Models\Services\Interfaces\IUserService::class)->getAllUsers();

try {
    ob_start();
    require 'views/admin/users/index.php';
    echo "SUCCESS";
} catch (\Throwable $e) {
    ob_end_clean();
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine();
}
