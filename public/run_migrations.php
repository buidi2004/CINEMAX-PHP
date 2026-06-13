<?php
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');

require_once ROOT_PATH . '/app/Core/Database.php';

use App\Core\Database;

spl_autoload_register(function (string $class) {
    if (str_starts_with($class, 'App\\')) {
        $relativeClass = substr($class, 4);
        $path = ROOT_PATH . '/app/' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
});

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = Database::getInstance();
    echo "<h1>Migration Status</h1>";
    echo "Connected to the database successfully.<br>";

    $files = [
        '001_create_users.sql',
        '002_create_movies.sql',
        '003_create_rooms.sql',
        '004_create_showtimes.sql',
        '005_create_tickets.sql',
        '006_create_promotions.sql',
        '007_seed_admin_user.sql',
        '008_seed_rooms.sql',
        '009_seed_data.sql',
        '010_create_cinemas.sql',
        '011_add_cinema_id_to_rooms.sql',
        '012_seed_cinemas.sql',
        '013_extend_users_profile.sql',
        '014_extend_admin_modules.sql'
    ];

    foreach ($files as $file) {
        $filePath = ROOT_PATH . '/migrations/' . $file;
        if (!file_exists($filePath)) {
            echo "Warning: File $file not found.<br>";
            continue;
        }
        $sql = file_get_contents($filePath);
        $pdo->exec($sql);
        echo "Successfully run $file.<br>";
    }

    echo "<h2>All migrations completed successfully!</h2>";
    echo "<a href='/'>Go to Homepage</a>";
} catch (\Throwable $e) {
    echo "Error running migrations: " . $e->getMessage() . "<br>";
}
