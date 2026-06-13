<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';

$updates = [
    'Godzilla x Kong: Đế Chế Mới' => 'https://m.media-amazon.com/images/M/MV5BN2E1ZWM1ZWYtY2FiMy00YzdkLThlNDktZmIyZTJhMWZkZGZlXkEyXkFqcGdeQXVyMTE0MzQwOTYz._V1_.jpg',
    'Dune: Hành Tinh Cát - Phần 2' => 'https://m.media-amazon.com/images/M/MV5BODdjMjM3NGQtZDA5OC00NGE4LWIyZDQtZjYwOGZlMTM5ZTQ1XkEyXkFqcGdeQXVyODE5NzE3OTE@._V1_FMjpg_UX1000_.jpg',
    'Gia Tài Của Ngoại' => 'https://m.media-amazon.com/images/M/MV5BYzA0NzllNWQtODBhNC00MjM2LWI3MDQtOGE3OWZkNjkyOGM5XkEyXkFqcGdeQXVyMTEzMTI1Mjk3._V1_.jpg',
    'Inside Out 2 (Những Mảnh Ghép Cảm Xúc 2)' => 'https://m.media-amazon.com/images/M/MV5BYTc1MTQxNjUpNjNhZS00MjAxLWE0YmItYTBmZDFiZGIwNmEzXkEyXkFqcGdeQXVyMTMxNjc5MTE4._V1_FMjpg_UX1000_.jpg',
    'Deadpool & Wolverine' => 'https://m.media-amazon.com/images/M/MV5BNzRiMjg0MzUtNTQ1Mi00Y2Q5LWEwM2MtMzUwZDVjNjQwYzg1XkEyXkFqcGdeQXVyMTE4NDIwBAB._V1_FMjpg_UX1000_.jpg',
    'Bỗng Dưng Trúng Số (6/45)' => 'https://m.media-amazon.com/images/M/MV5BZmIyYTNhZjItMmY4MS00MTIzLWFhY2MtM2UwMWQyOGQwOWY0XkEyXkFqcGdeQXVyNTI5NjIyMw@@._V1_FMjpg_UX1000_.jpg',
    'Exhuma: Quật Mộ Trùng Ma' => 'https://m.media-amazon.com/images/M/MV5BODg4NDgxOGQtNWQ3NC00ODg0LWI4ZjMtNDkzZGUwM2MyYzUzXkEyXkFqcGdeQXVyMTMzMzI1Njc2._V1_FMjpg_UX1000_.jpg',
    'Mai' => 'https://m.media-amazon.com/images/M/MV5BZTU0MTFjZmItNTkwZC00Mzg3LWEwN2UtMzJjMDgwZjBkZWM5XkEyXkFqcGdeQXVyMzQwMTY2Nzk@._V1_FMjpg_UX1000_.jpg',
    'Lật Mặt 7: Một Điều Ước' => 'https://m.media-amazon.com/images/M/MV5BOGZmNWI4MTUtZGJhZi00MjhlLWEzZmYtNWI2NzhhYWZjOWMwXkEyXkFqcGdeQXVyMjUyMzg5Njk@._V1_FMjpg_UX1000_.jpg'
];

$db = \App\Core\Database::getInstance();
$stmt = $db->prepare("UPDATE movies SET poster_url = ? WHERE title = ?");

foreach ($updates as $title => $url) {
    $stmt->execute([$url, $title]);
}
echo "Updated poster URLs!";
