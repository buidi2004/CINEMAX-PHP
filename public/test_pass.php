<?php
$hash = '$2y$12$btJP6j/OQ0/gN/qRyEzohu53f4JbM8WX6dUGaeY7QEUvNXgUJj3Py';
$passwords = ['admin', 'password', '123456', 'admin123', 'root', 'cinemax'];

foreach ($passwords as $p) {
    if (password_verify($p, $hash)) {
        echo "FOUND: $p\n";
        exit(0);
    }
}
echo "NOT FOUND\n";
