<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';

$movies = [
    'Godzilla x Kong' => 'Godzilla x Kong',
    'Dune: Hành Tinh Cát - Phần 2' => 'Dune Part Two',
    'Gia Tài Của Ngoại' => 'How to Make Millions Before Grandma Dies',
    'Inside Out 2' => 'Inside Out 2',
    'Deadpool & Wolverine' => 'Deadpool Wolverine',
    'Bỗng Dưng Trúng Số' => '6/45',
    'Exhuma' => 'Exhuma',
    'Mai' => 'Mai Tran Thanh',
    'Lật Mặt 7' => 'Lat Mat 7'
];

$db = \App\Core\Database::getInstance();
$stmt = $db->prepare("UPDATE movies SET poster_url = ? WHERE title LIKE ?");

foreach ($movies as $dbTitle => $searchQuery) {
    $url = "https://itunes.apple.com/search?term=" . urlencode($searchQuery) . "&media=movie&limit=1";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    if (!empty($data['results'][0]['artworkUrl100'])) {
        $poster = str_replace('100x100bb.jpg', '600x900bb.jpg', $data['results'][0]['artworkUrl100']);
        $stmt->execute([$poster, "%$dbTitle%"]);
        echo "Updated $dbTitle with $poster\n";
    } else {
        echo "Could not find $searchQuery on iTunes\n";
    }
}
