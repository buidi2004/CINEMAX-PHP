<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';

$movies = [
    'Godzilla x Kong' => 'https://upload.wikimedia.org/wikipedia/en/b/b3/Godzilla_x_Kong_The_New_Empire_poster.jpg',
    'Dune: Hành Tinh Cát - Phần 2' => 'https://upload.wikimedia.org/wikipedia/en/8/8e/Dune_Part_Two_poster.jpg',
    'Gia Tài Của Ngoại' => 'https://upload.wikimedia.org/wikipedia/en/b/b8/How_to_Make_Millions_Before_Grandma_Dies_poster.jpg',
    'Inside Out 2' => 'https://upload.wikimedia.org/wikipedia/en/f/f7/Inside_Out_2_poster.jpg',
    'Deadpool & Wolverine' => 'https://upload.wikimedia.org/wikipedia/en/4/4c/Deadpool_%26_Wolverine_poster.jpg',
    'Bỗng Dưng Trúng Số' => 'https://upload.wikimedia.org/wikipedia/en/3/36/6_45_poster.jpg',
    'Exhuma' => 'https://upload.wikimedia.org/wikipedia/en/9/91/Exhuma_%28film%29_poster.jpg',
    'Mai' => 'https://upload.wikimedia.org/wikipedia/en/e/eb/Mai_2024_poster.jpg',
    'Lật Mặt 7' => 'https://upload.wikimedia.org/wikipedia/vi/a/a2/L%E1%BA%ADt_m%E1%BA%B7t_7.jpg'
];

$db = \App\Core\Database::getInstance();
$stmt = $db->prepare("UPDATE movies SET poster_url = ? WHERE title LIKE ?");

$targetDir = ROOT_PATH . '/public/assets/images/movies';

foreach ($movies as $title => $url) {
    $filename = md5($title) . '.jpg';
    $filepath = $targetDir . '/' . $filename;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $imgData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200 && $imgData) {
        file_put_contents($filepath, $imgData);
        $localUrl = '/assets/images/movies/' . $filename;
        $stmt->execute([$localUrl, "%$title%"]);
        echo "Tải thành công $title: $localUrl\n";
    } else {
        echo "Lỗi khi tải $title (HTTP $httpCode)\n";
    }
}
