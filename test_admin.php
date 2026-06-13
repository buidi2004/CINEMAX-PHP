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
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'admin';

$container = require_once CONFIG_PATH . '/app.php';

$_SERVER['REQUEST_URI'] = '/admin/dashboard';
$_SERVER['REQUEST_METHOD'] = 'GET';

$controllers = [
    \App\Controllers\Admin\DashboardController::class,
    \App\Controllers\Admin\MovieController::class,
    \App\Controllers\Admin\ShowtimeController::class,
    \App\Controllers\Admin\FoodBeverageController::class,
    \App\Controllers\Admin\PromotionController::class,
    \App\Controllers\Admin\CinemaController::class,
    \App\Controllers\Admin\NewsController::class,
    \App\Controllers\Admin\UserController::class,
    \App\Controllers\Admin\ReviewController::class,
    \App\Controllers\Admin\ContactController::class,
    \App\Controllers\Admin\SettingController::class,
    \App\Controllers\Admin\ReportController::class
];

foreach ($controllers as $class) {
    try {
        ob_start();
        $controller = new $class($container);
        $controller->index();
        $output = ob_get_clean();
        echo "[OK] $class\n";
    } catch (\Throwable $e) {
        ob_end_clean();
        echo "[ERROR] $class : " . $e->getMessage() . " on line " . $e->getLine() . "\n";
    }
}
