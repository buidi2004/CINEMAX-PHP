<?php
$files = [
    'app/Controllers/Admin/CinemaController.php',
    'app/Controllers/Admin/PromotionController.php'
];
foreach($files as $f) {
    $content = file_get_contents($f);
    // remove all non-whitespace characters before <?php
    $content = preg_replace('/^.*?<\?php/s', "<?php", $content);
    file_put_contents($f, $content);
}
