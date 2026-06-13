<?php
$f = '/var/www/html/views/movie/detail.php';
$c = file_get_contents($f);
$c = str_replace('bg-black', 'bg-white', $c);
file_put_contents($f, $c);
echo "Fixed";
