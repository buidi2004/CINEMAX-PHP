<?php
$f = '/var/www/html/views/promotions/index.php';
$c = file_get_contents($f);

// Add width and margin to break out of container
$cssFix = <<<CSS
.horizontal-scroll-container {
    position: relative;
    width: 100vw;
    margin-left: calc(-50vw + 50%);
}
CSS;

$c = str_replace('.horizontal-scroll-container {
    position: relative;
}', $cssFix, $c);

file_put_contents($f, $c);
echo "Fixed";
