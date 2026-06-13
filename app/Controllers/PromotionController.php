<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Database;

class PromotionController extends BaseController
{
    private \PDO $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = Database::getInstance();
    }

    // GET /promotions
    public function index(): void
    {
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
            ],
            (object)[
                'id' => 4, 'code' => 'CINEMAXVIP', 'discount_type' => 'percent', 'discount_value' => 30,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+10 days')), 'used_count' => 5, 'max_uses' => 100,
                'image_url' => 'https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop'
            ]
        ];

        $this->render('promotions.index', [
            'promotions'     => $promotions,
            'featuredPromos' => array_slice($promotions, 0, 3),
            'pageTitle'      => 'Khuyến mãi — CinemaX',
        ]);
    }

    // GET /promotions/{id}
    public function detail(int $id): void
    {
        $stmt = $this->db->prepare("SELECT * FROM promotions WHERE id = :id AND is_active = TRUE");
        $stmt->execute(['id' => $id]);
        $promo = $stmt->fetch(\PDO::FETCH_OBJ);

        if (!$promo) {
            http_response_code(404);
            $this->render('errors.404', ['pageTitle' => 'Không tìm thấy']);
            return;
        }

        $this->render('promotions.detail', [
            'promo'     => $promo,
            'pageTitle' => ($promo->code ?? 'Khuyến mãi') . ' — CinemaX',
        ]);
    }
}
