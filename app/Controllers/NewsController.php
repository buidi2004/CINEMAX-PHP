<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Database;

class NewsController extends BaseController
{
    private \PDO $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = Database::getInstance();
    }

    // GET /news
    public function index(): void
    {
        // --- MOCK DATA FOR NEWS ---
        $articles = [
            (object)[
                'title' => 'Review Dune Part 2: Cảnh Tượng Nghẹt Thở Tại Hành Tinh Cát', 'slug' => 'review-dune-part-2', 'category' => 'Góc Điện Ảnh',
                'image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800&auto=format&fit=crop',
                'summary' => 'Siêu phẩm điện ảnh của Denis Villeneuve tiếp tục chứng minh sức mạnh thị giác vô tiền khoáng hậu tại định dạng IMAX.',
                'published_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')
            ],
            (object)[
                'title' => 'Top 5 Phim Việt Nam Đáng Xem Nhất Hiện Tại', 'slug' => 'top-5-phim-viet-nam', 'category' => 'Top List',
                'image_url' => 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=800&auto=format&fit=crop',
                'summary' => 'Điểm danh những bộ phim chiếu rạp làm mưa làm gió tại phòng vé Việt trong những ngày vừa qua.',
                'published_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')
            ],
            (object)[
                'title' => 'Christopher Nolan Hé Lộ Dự Án Mới Về Đề Tài Vũ Trụ', 'slug' => 'christopher-nolan-du-an-moi', 'category' => 'Tin Hollywood',
                'image_url' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800&auto=format&fit=crop',
                'summary' => 'Sau thành công vang dội của Oppenheimer, vị đạo diễn kiệt xuất dự kiến sẽ quay lại thể loại Sci-Fi sở trường.',
                'published_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $featured = $articles[0];

        $this->render('news.index', [
            'featured'  => $featured,
            'articles'  => $articles,
            'pageTitle' => 'Tin tức — CinemaX',
        ]);
    }

    // GET /news/{slug}
    public function detail(string $slug): void
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM news WHERE slug = :slug");
            $stmt->execute(['slug' => $slug]);
            $article = $stmt->fetch(\PDO::FETCH_OBJ);

            if (!$article) {
                http_response_code(404);
                $this->render('errors.404', ['pageTitle' => 'Không tìm thấy']);
                return;
            }

            // Views tracking is not in current schema, skip it.

            $this->render('news.detail', [
                'article'   => $article,
                'pageTitle' => $article->title . ' — CinemaX',
            ]);
        } catch (\Exception $e) {
            http_response_code(404);
            $this->render('errors.404', ['pageTitle' => 'Không tìm thấy']);
        }
    }
}
