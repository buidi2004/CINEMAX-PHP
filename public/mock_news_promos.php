<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

try {
    $db = Database::getInstance();

    // 1. Alter promotions table
    try {
        $db->exec("ALTER TABLE promotions ADD COLUMN image_url VARCHAR(255) NULL");
    } catch (\Exception $e) {
        // Column might already exist, ignore
    }

    // 2. Create news table
    $db->exec("CREATE TABLE IF NOT EXISTS news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        category VARCHAR(100),
        image_url VARCHAR(255),
        summary TEXT,
        content TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 3. Mock Promotions
    $promotions = [
        [
            'code' => 'SUMMER2026',
            'discount_type' => 'percent',
            'discount_value' => 20,
            'max_uses' => 1000,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop'
        ],
        [
            'code' => 'VALENTINE',
            'discount_type' => 'percent',
            'discount_value' => 15,
            'max_uses' => 500,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 days')),
            'image_url' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?q=80&w=800&auto=format&fit=crop'
        ],
        [
            'code' => 'TUESDAY',
            'discount_type' => 'fixed',
            'discount_value' => 50000,
            'max_uses' => NULL,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+90 days')),
            'image_url' => 'https://images.unsplash.com/photo-1440407876336-62333a6f010f?q=80&w=800&auto=format&fit=crop'
        ],
        [
            'code' => 'CINEMAXVIP',
            'discount_type' => 'percent',
            'discount_value' => 30,
            'max_uses' => 100,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+10 days')),
            'image_url' => 'https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop'
        ]
    ];

    $promoCount = 0;
    foreach ($promotions as $p) {
        $stmt = $db->prepare("SELECT id FROM promotions WHERE code = ?");
        $stmt->execute([$p['code']]);
        if (!$stmt->fetch()) {
            $insert = $db->prepare("INSERT INTO promotions (code, discount_type, discount_value, max_uses, expires_at, image_url) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->execute([$p['code'], $p['discount_type'], $p['discount_value'], $p['max_uses'], $p['expires_at'], $p['image_url']]);
            $promoCount++;
        }
    }

    // 4. Mock News
    $news = [
        [
            'title' => 'Review Dune Part 2: Cảnh Tượng Nghẹt Thở Tại Hành Tinh Cát',
            'slug' => 'review-dune-part-2',
            'category' => 'Góc Điện Ảnh',
            'image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop',
            'summary' => 'Siêu phẩm điện ảnh của Denis Villeneuve tiếp tục chứng minh sức mạnh thị giác vô tiền khoáng hậu tại định dạng IMAX.',
            'content' => 'Nội dung bài viết review Dune Part 2...'
        ],
        [
            'title' => 'Top 5 Phim Việt Nam Đáng Xem Nhất Hiện Tại',
            'slug' => 'top-5-phim-viet-nam',
            'category' => 'Top List',
            'image_url' => 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=800&auto=format&fit=crop',
            'summary' => 'Điểm danh những bộ phim chiếu rạp làm mưa làm gió tại phòng vé Việt trong những ngày vừa qua.',
            'content' => 'Nội dung bài viết top 5 phim Việt Nam...'
        ],
        [
            'title' => 'Christopher Nolan Hé Lộ Dự Án Mới Về Đề Tài Vũ Trụ',
            'slug' => 'christopher-nolan-du-an-moi',
            'category' => 'Tin Hollywood',
            'image_url' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800&auto=format&fit=crop',
            'summary' => 'Sau thành công vang dội của Oppenheimer, vị đạo diễn kiệt xuất dự kiến sẽ quay lại thể loại Sci-Fi sở trường.',
            'content' => 'Nội dung tin tức Christopher Nolan...'
        ]
    ];

    $newsCount = 0;
    foreach ($news as $n) {
        $stmt = $db->prepare("SELECT id FROM news WHERE slug = ?");
        $stmt->execute([$n['slug']]);
        if (!$stmt->fetch()) {
            $insert = $db->prepare("INSERT INTO news (title, slug, category, image_url, summary, content) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->execute([$n['title'], $n['slug'], $n['category'], $n['image_url'], $n['summary'], $n['content']]);
            $newsCount++;
        }
    }

    echo "<h3>Cập nhật thành công!</h3>";
    echo "<p>- Đã chèn $promoCount khuyến mãi.</p>";
    echo "<p>- Đã chèn $newsCount bài viết tin tức.</p>";
    echo "<p><a href='/'>Quay lại trang chủ</a> | <a href='/promotions'>Xem trang Khuyến Mãi</a> | <a href='/news'>Xem trang Tin Tức</a></p>";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
