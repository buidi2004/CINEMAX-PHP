<?php
// config/database.php
return [
    'driver'   => 'mysql',
    'host'     => getenv('DB_HOST')     ?: 'localhost',
    'port'     => getenv('DB_PORT')     ?: '3306',
    'dbname'   => getenv('DB_NAME')     ?: 'cinema_db',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset'  => 'utf8mb4',
];

