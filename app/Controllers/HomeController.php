<?php
namespace App\Controllers;

use App\Core\Container;
use App\Models\Services\Interfaces\IMovieService;

class HomeController extends BaseController
{
    private IMovieService $movieService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->movieService = $container->make(IMovieService::class);
    }

    // GET /
    public function index(): void
    {
        $nowShowing = $this->movieService->getNowShowing();
        $comingSoon = $this->movieService->getComingSoon();

        $db = \App\Core\Database::getInstance();
        
        // --- MOCK DATA FOR PROMOTIONS ---
        $promotions = [
            (object)[
                'id' => 1, 'code' => 'SUMMER2026', 'discount_type' => 'percent', 'discount_value' => 20, 
                'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days')), 'used_count' => 50, 'max_uses' => 1000,
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=800&auto=format&fit=crop'
            ],
            (object)[
                'id' => 2, 'code' => 'VALENTINE', 'discount_type' => 'percent', 'discount_value' => 15,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+15 days')), 'used_count' => 10, 'max_uses' => 500,
                'image_url' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?q=80&w=800&auto=format&fit=crop'
            ],
            (object)[
                'id' => 3, 'code' => 'TUESDAY', 'discount_type' => 'fixed', 'discount_value' => 50000,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+90 days')), 'used_count' => 200, 'max_uses' => null,
                'image_url' => 'https://images.unsplash.com/photo-1440407876336-62333a6f010f?q=80&w=800&auto=format&fit=crop'
            ]
        ];

        // --- MOCK DATA FOR NEWS ---
        $news = [
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

        $this->render('home.index', [
            'nowShowing' => $nowShowing,
            'comingSoon' => $comingSoon,
            'promotions' => $promotions,
            'news'       => $news,
            'pageTitle'  => 'CinemaX — Đặt vé trực tuyến',
        ]);
    }
}
