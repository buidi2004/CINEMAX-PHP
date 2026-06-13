<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';
\App\Core\Database::getInstance()->query('ALTER TABLE tickets ADD COLUMN food_items JSON NULL');
\App\Core\Database::getInstance()->query('ALTER TABLE tickets ADD COLUMN food_price DECIMAL(10,2) DEFAULT 0');
echo 'OK';
