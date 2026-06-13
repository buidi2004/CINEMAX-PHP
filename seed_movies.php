<?php
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
require 'app/Core/Database.php';

$movies = [
    [
        'title' => 'Lật Mặt 7: Một Điều Ước',
        'description' => 'Câu chuyện cảm động về tình mẫu tử, gia đình và những điều ước giản đơn trong cuộc sống hàng ngày của người phụ nữ đơn thân nuôi 5 người con.',
        'duration_minutes' => 138,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/8tH8z7oOhv1xY6Xb3uA1XNpbjN9.jpg',
        'status' => 'now_showing',
        'genre' => 'Tâm lý, Gia đình',
        'age_rating' => 'P'
    ],
    [
        'title' => 'Mai',
        'description' => 'Bộ phim tâm lý tình cảm xoay quanh cuộc đời sóng gió của Mai - một người phụ nữ làm nghề massage có số phận éo le và tình yêu với chàng trai trẻ.',
        'duration_minutes' => 131,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/1X7Bcb42x9oT.jpg', 
        'status' => 'now_showing',
        'genre' => 'Tâm lý, Tình cảm',
        'age_rating' => 'C18'
    ],
    [
        'title' => 'Exhuma: Quật Mộ Trùng Ma',
        'description' => 'Một bộ phim kinh dị siêu nhiên Hàn Quốc xoay quanh một nhóm pháp sư, thầy phong thủy và người làm nghề mai táng tìm cách hóa giải một lời nguyền đáng sợ.',
        'duration_minutes' => 134,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/1ZSQtp0A1Jz6Y89V8B2W9tK7lJw.jpg',
        'status' => 'now_showing',
        'genre' => 'Kinh dị, Hồi hộp',
        'age_rating' => 'C16'
    ],
    [
        'title' => 'Gia Tài Của Ngoại',
        'description' => 'Chàng trai trẻ quyết định nghỉ việc để về chăm sóc người bà đang mắc bệnh ung thư giai đoạn cuối với hy vọng nhận được tài sản thừa kế.',
        'duration_minutes' => 125,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/pIuEBTY24o3vRjZ6iN1Qo0c4wHw.jpg',
        'status' => 'now_showing',
        'genre' => 'Hài, Gia đình',
        'age_rating' => 'P'
    ],
    [
        'title' => 'Deadpool & Wolverine',
        'description' => 'Deadpool trở lại và hợp tác cùng Wolverine trong một cuộc phiêu lưu đa vũ trụ đầy bạo lực và hài hước để cứu lấy thế giới của mình.',
        'duration_minutes' => 127,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/8cdWjvZQUExUUTzyp4t6EDMubfO.jpg',
        'status' => 'coming_soon',
        'genre' => 'Hành động, Hài',
        'age_rating' => 'C18'
    ],
    [
        'title' => 'Inside Out 2 (Những Mảnh Ghép Cảm Xúc 2)',
        'description' => 'Riley bước vào tuổi dậy thì, và Trụ sở chính đối mặt với cuộc cải tổ bất ngờ để nhường chỗ cho những Cảm xúc mới.',
        'duration_minutes' => 96,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/vpnVM9B6NMmQpWeZvzLvDESb2QY.jpg',
        'status' => 'now_showing',
        'genre' => 'Hoạt hình, Gia đình',
        'age_rating' => 'P'
    ],
    [
        'title' => 'Dune: Hành Tinh Cát - Phần 2',
        'description' => 'Paul Atreides đồng hành cùng Chani và người Fremen trên con đường trả thù những kẻ đã hủy hoại gia đình anh.',
        'duration_minutes' => 166,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2JGjjc9CW.jpg',
        'status' => 'now_showing',
        'genre' => 'Khoa học viễn tưởng, Hành động',
        'age_rating' => 'C13'
    ],
    [
        'title' => 'Godzilla x Kong: Đế Chế Mới',
        'description' => 'Hai siêu quái vật cổ đại Godzilla và Kong phải gạt bỏ hận thù để đối đầu với một mối đe dọa ẩn sâu trong Trái Đất.',
        'duration_minutes' => 115,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/z1p34vh7dEOnLDmyCrlUVLuoDts.jpg',
        'status' => 'now_showing',
        'genre' => 'Hành động, Viễn tưởng',
        'age_rating' => 'C13'
    ],
    [
        'title' => 'Bỗng Dưng Trúng Số (6/45)',
        'description' => 'Một cuộc đụng độ hài hước giữa binh lính Nam và Bắc Triều Tiên vì một tờ vé số trúng thưởng độc đắc bị gió cuốn bay qua biên giới.',
        'duration_minutes' => 113,
        'poster_url' => 'https://image.tmdb.org/t/p/w500/4zT4n1p3i2h5Bv4g9tU8vT4vB1g.jpg',
        'status' => 'ended',
        'genre' => 'Hài, Tâm lý',
        'age_rating' => 'C13'
    ]
];

$db = \App\Core\Database::getInstance();

try {
    $db->beginTransaction();
    
    $stmt = $db->prepare("INSERT INTO movies (title, description, duration_minutes, poster_url, status, genre, age_rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $movieIndex = 0;
    foreach ($movies as $movie) {
        $stmt->execute([
            $movie['title'],
            $movie['description'],
            $movie['duration_minutes'],
            $movie['poster_url'],
            $movie['status'],
            $movie['genre'],
            $movie['age_rating']
        ]);
        $movieId = $db->lastInsertId();
        
        if ($movie['status'] === 'now_showing') {
            for ($i = 0; $i < 3; $i++) {
                $date = date('Y-m-d', strtotime("+$i days"));
                // Add unique minute to avoid duplicate collisions
                $time1 = sprintf("%02d:%02d:00", 8 + ($movieIndex % 12), $movieIndex % 60);
                $time2 = sprintf("%02d:%02d:00", 10 + ($movieIndex % 12), $movieIndex % 60);
                
                $db->prepare("INSERT IGNORE INTO showtimes (movie_id, room_id, show_date, start_time, price) VALUES (?, 1, ?, ?, 100000)")
                   ->execute([$movieId, $date, $time1]);
                $db->prepare("INSERT IGNORE INTO showtimes (movie_id, room_id, show_date, start_time, price) VALUES (?, 2, ?, ?, 120000)")
                   ->execute([$movieId, $date, $time2]);
            }
        }
        $movieIndex++;
    }
    
    $db->commit();
    echo "Seed thanh cong!";
} catch (\Exception $e) {
    $db->rollBack();
    echo "Loi: " . $e->getMessage();
}

