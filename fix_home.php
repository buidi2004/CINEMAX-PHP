<?php
$f = '/var/www/html/views/home/index.php';
$c = file_get_contents($f);

// Fix scale on scroll wrapper
$c = str_replace(
    '<div class="scroll-zoom-wrapper mt-5" style="height: 250vh; position: relative;">',
    '<div class="scroll-zoom-wrapper mt-5" style="height: 250vh; position: relative; width: 100vw; margin-left: calc(-50vw + 50%); overflow-x: hidden;">',
    $c
);

file_put_contents($f, $c);
echo "Fixed home";
