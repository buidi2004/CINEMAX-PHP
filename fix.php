<?php
function fix_encoding($filepath) {
    if (!file_exists($filepath)) return;
    $content = file_get_contents($filepath);
    $fixed = mb_convert_encoding($content, 'Windows-1252', 'UTF-8');
    file_put_contents($filepath, $fixed);
}

fix_encoding('/var/www/html/views/home/index.php');
fix_encoding('/var/www/html/views/partials/navbar.php');
fix_encoding('/var/www/html/views/movie/detail.php');
fix_encoding('/var/www/html/views/news/index.php');
fix_encoding('/var/www/html/views/payment/index.php');
fix_encoding('/var/www/html/views/cinemas/index.php');
