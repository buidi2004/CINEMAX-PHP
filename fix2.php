<?php
$filepath = '/var/www/html/views/home/index.php';
$content = file_get_contents($filepath);
$fixed = mb_convert_encoding($content, 'Windows-1252', 'UTF-8');
file_put_contents($filepath, $fixed);
echo "Done";
