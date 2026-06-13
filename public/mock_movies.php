<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

try {
    $db = Database::getInstance();

    // Mock movies: Vietnamese and Thai
    $movies = [
        // Vietnamese movies
        [
            'title' => 'Bố Già',
            'poster_url' => 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=800&auto=format&fit=crop',
            'genre' => 'Hài kịch, Gia đình',
            'status' => 'now_showing',
            'duration_minutes' => 128,
            'description' => 'Bố Già xoay quanh câu chuyện thường nhật của ông Ba Sang, một người cha đơn thân làm nghề chở hàng thuê...',
            'age_rating' => 'C13'
        ],
        [
            'title' => 'Mai',
            'poster_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop',
            'genre' => 'Tình cảm, Tâm lý',
            'status' => 'now_showing',
            'duration_minutes' => 131,
            'description' => 'Câu chuyện về Mai, một người phụ nữ mang nhiều góc khuất, làm nghề massage và khao khát được yêu thương...',
            'age_rating' => 'C18'
        ],
        [
            'title' => 'Lật Mặt 7: Một Điều Ước',
            'poster_url' => 'https://images.unsplash.com/photo-1440407876336-62333a6f010f?q=80&w=800&auto=format&fit=crop',
            'genre' => 'Hành động, Gia đình',
            'status' => 'coming_soon',
            'duration_minutes' => 110,
            'description' => 'Bộ phim thứ 7 trong series Lật Mặt đình đám của đạo diễn Lý Hải, xoay quanh tình cảm gia đình cảm động...',
            'age_rating' => 'C16'
        ],
        // Thai movies
        [
            'title' => 'Ngược Dòng Thời Gian Để Yêu Anh (Buppha Sanniwat)',
            'poster_url' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?q=80&w=800&auto=format&fit=crop',
            'genre' => 'Hài kịch, Lãng mạn',
            'status' => 'now_showing',
            'duration_minutes' => 166,
            'description' => 'Phiên bản điện ảnh tiếp nối câu chuyện tình yêu vượt thời gian cực kỳ ăn khách của Thái Lan...',
            'age_rating' => 'C13'
        ],
        [
            'title' => 'Tình Người Duyên Ma (Pee Mak)',
            'poster_url' => 'https://images.unsplash.com/photo-1509347528160-9a9e33742cdb?q=80&w=800&auto=format&fit=crop',
            'genre' => 'Kinh dị, Hài',
            'status' => 'coming_soon',
            'duration_minutes' => 115,
            'description' => 'Câu chuyện kinh dị và hài hước về chàng Mak và người vợ Nak, mang lại tiếng cười và những giọt nước mắt...',
            'age_rating' => 'C16'
        ],
        [
            'title' => 'Thiên Tài Bất Hảo (Bad Genius)',
            'poster_url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=800&auto=format&fit=crop',
            'genre' => 'Hồi hộp, Học đường',
            'status' => 'coming_soon',
            'duration_minutes' => 130,
            'description' => 'Một nhóm học sinh thiên tài tìm cách vượt qua các bài thi quốc tế để kiếm tiền tỷ...',
            'age_rating' => 'C13'
        ]
    ];

    $count = 0;
    foreach ($movies as $m) {
        $stmt = $db->prepare("SELECT id FROM movies WHERE title = ?");
        $stmt->execute([$m['title']]);
        if (!$stmt->fetch()) {
            $insert = $db->prepare("INSERT INTO movies (title, poster_url, genre, status, duration_minutes, description, age_rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert->execute([$m['title'], $m['poster_url'], $m['genre'], $m['status'], $m['duration_minutes'], $m['description'], $m['age_rating']]);
            $count++;
        }
    }

    echo "<h3>Đã chèn thành công $count bộ phim (Việt Nam & Thái Lan) vào cơ sở dữ liệu!</h3>";
    echo "<p><a href='/'>Quay lại trang chủ</a></p>";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
