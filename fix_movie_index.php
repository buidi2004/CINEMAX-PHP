<?php
$f = '/var/www/html/views/movie/index.php';
$c = file_get_contents($f);

// Title
$c = str_replace('text-light mb-3">Danh Sách Phim', 'text-dark mb-3">Danh Sách Phim', $c);

// Filter container
$c = str_replace('bg-black border border-secondary p-3', 'bg-white border border-light p-3', $c);
$c = str_replace('btn-outline-secondary', 'btn-outline-dark', $c);

// Dropdown
$c = str_replace('dropdown-menu-dark dropdown-menu-end border-secondary bg-black', 'dropdown-menu-end border-light bg-white', $c);

// Movie cards
$c = str_replace('card bg-black border border-secondary', 'card bg-white border border-light', $c);
$c = str_replace('card-body p-3 bg-black', 'card-body p-3 bg-white', $c);
$c = str_replace('card-title text-light', 'card-title text-dark', $c);

file_put_contents($f, $c);
echo "Fixed movie index theme";
