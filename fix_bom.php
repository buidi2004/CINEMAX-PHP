<?php
$f = '/var/www/html/app/Controllers/HomeController.php';
$c = file_get_contents($f);
// remove BOM if exists
if (substr($c, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
    $c = substr($c, 3);
}
// remove any whitespace before <?php
$c = trim($c);
if (strpos($c, '<?php') !== 0) {
    $c = "<?php\n" . substr($c, strpos($c, 'namespace'));
}
file_put_contents($f, $c);
echo "Fixed BOM";
