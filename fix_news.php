<?php
$f = '/var/www/html/views/news/index.php';
$c = file_get_contents($f);

// Fix scale on scroll wrapper
$c = str_replace(
    '<div class="featured-scroll-sequence mb-5" style="height: 250vh; position: relative; margin-top: -1.5rem;">',
    '<div class="featured-scroll-sequence mb-5" style="height: 250vh; position: relative; margin-top: -1.5rem; width: 100vw; margin-left: calc(-50vw + 50%); overflow-x: hidden;">',
    $c
);

file_put_contents($f, $c);
echo "Fixed news";
