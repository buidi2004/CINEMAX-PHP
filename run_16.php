<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';
$db = \App\Core\Database::getInstance();
$db->query("ALTER TABLE promotions ADD COLUMN title VARCHAR(150) NULL AFTER code");
$db->query("ALTER TABLE promotions ADD COLUMN description TEXT NULL AFTER title");
$db->query("ALTER TABLE promotions ADD COLUMN image_url VARCHAR(255) NULL AFTER description");
echo 'OK';
