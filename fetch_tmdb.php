<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';

$movies = [
    'Godzilla x Kong: Đế Chế Mới' => 'Godzilla x Kong',
    'Dune: Hành Tinh Cát - Phần 2' => 'Dune Part Two',
    'Gia Tài Của Ngoại' => 'How to Make Millions Before Grandma Dies',
    'Inside Out 2 (Những Mảnh Ghép Cảm Xúc 2)' => 'Inside Out 2',
    'Deadpool & Wolverine' => 'Deadpool Wolverine',
    'Bỗng Dưng Trúng Số (6/45)' => '6/45',
    'Exhuma: Quật Mộ Trùng Ma' => 'Exhuma',
    'Mai' => 'Mai',
    'Lật Mặt 7: Một Điều Ước' => 'Lat Mat 7'
];

$db = \App\Core\Database::getInstance();
$stmt = $db->prepare("UPDATE movies SET poster_url = ? WHERE title = ?");

foreach ($movies as $dbTitle => $searchQuery) {
    $url = "https://api.themoviedb.org/3/search/movie?api_key=4e44d9029b1270a757cddc766a1bcb63&query=" . urlencode($searchQuery);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if (!empty($data['results'][0]['poster_path'])) {
        $posterUrl = "https://image.tmdb.org/t/p/w500" . $data['results'][0]['poster_path'];
        $stmt->execute([$posterUrl, $dbTitle]);
        echo "Cập nhật thành công $dbTitle: $posterUrl\n";
    } else {
        echo "Không tìm thấy ảnh cho $dbTitle\n";
    }
}
