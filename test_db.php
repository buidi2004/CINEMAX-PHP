<?php
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
require_once ROOT_PATH . '/vendor/autoload.php';
$db = \App\Core\Database::getInstance();
$stmt = $db->query('DESCRIBE news');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
$stmt = $db->query('DESCRIBE contacts');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
