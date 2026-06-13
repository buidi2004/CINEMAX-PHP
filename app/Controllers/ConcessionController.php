<?php
namespace App\Controllers;

use App\Core\Container;

class ConcessionController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function detail(string $slug): void
    {
        // Mock data for concessions
        $concessions = [
            'combo-avatar' => [
                'name' => 'Combo Avatar: The Way of Water',
                'price' => '299.000₫',
                'image' => 'https://placehold.co/800x400/2a1a1a/e5a720?text=Combo+Avatar',
                'video' => 'https://www.youtube.com/embed/o5F8MOz_IDw?autoplay=1&mute=1&loop=1&playlist=o5F8MOz_IDw',
                'description' => '
                    <p class="fs-5 text-light">Hòa mình vào thế giới Pandora diệu kỳ với <strong>Combo Avatar: The Way of Water</strong> độc quyền tại CinemaX. Không chỉ là một phần bắp nước thông thường, đây là một tác phẩm nghệ thuật dành riêng cho các fan hâm mộ chân chính của siêu phẩm đến từ đạo diễn James Cameron.</p>
                    <h5 class="text-warning mt-4 mb-3">Combo bao gồm:</h5>
                    <ul class="list-group list-group-flush bg-transparent text-light mb-4">
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>1 Ly nước tạo hình nhân vật Na\'vi (có thể tái sử dụng)</strong> - Thiết kế tinh xảo, chất liệu nhựa cao cấp an toàn cho sức khỏe.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>1 Bắp khổng lồ (Size L)</strong> - Thỏa sức lựa chọn vị Phô mai, Caramel hoặc Truyền thống.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>Tặng kèm 1 Postcard 3D phiên bản giới hạn</strong> - Hình ảnh đại dương Pandora sống động.</li>
                    </ul>
                    <h5 class="text-warning mt-4 mb-3">Thông tin chi tiết:</h5>
                    <p>Sản phẩm được cấp bản quyền chính thức từ 20th Century Studios. Số lượng có hạn, ưu tiên khách hàng đặt trước qua website hoặc ứng dụng CinemaX. Nhanh tay sở hữu ngay để chuyến phiêu lưu đến Pandora thêm trọn vẹn!</p>
                '
            ],
            'combo-couple' => [
                'name' => 'Combo Couple (Dành cho cặp đôi)',
                'price' => '109.000₫',
                'image' => 'https://placehold.co/800x400/2a1a1a/e5a720?text=Combo+Couple',
                'video' => 'https://www.youtube.com/embed/lM0hDngTzVw?autoplay=1&mute=1',
                'description' => '
                    <p class="fs-5 text-light">Chia sẻ khoảnh khắc ngọt ngào cùng người thương với <strong>Combo Couple</strong>. Tiết kiệm hơn 20% so với mua lẻ, đây là sự lựa chọn hoàn hảo cho buổi hẹn hò điện ảnh lãng mạn.</p>
                    <h5 class="text-warning mt-4 mb-3">Combo bao gồm:</h5>
                    <ul class="list-group list-group-flush bg-transparent text-light mb-4">
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>2 Ly nước ngọt (Size M)</strong> - Pepsi, 7Up, Mirinda tùy chọn.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i><strong>1 Bắp lớn (Size L)</strong> - Được mix 2 vị tùy thích (Caramel/Phô mai).</li>
                    </ul>
                    <div class="alert alert-info bg-dark border-info text-light mt-4">
                        <strong><i class="bi bi-info-circle me-2 text-info"></i>Ưu đãi thêm:</strong> Khách hàng thành viên hạng Gold trở lên được miễn phí up size nước khi mua Combo Couple.
                    </div>
                '
            ],
            'dune-merch' => [
                'name' => 'Dune Merchandise: Sandworm Bucket',
                'price' => '399.000₫',
                'image' => 'https://placehold.co/800x400/2a1a1a/e5a720?text=Dune+Merchandise',
                'video' => 'https://www.youtube.com/embed/Way9Dexny3w?autoplay=1&mute=1&loop=1&playlist=Way9Dexny3w',
                'description' => '
                    <p class="fs-5 text-light">Chào mừng đến với Arrakis! Trải nghiệm điện ảnh đỉnh cao cùng <strong>Exclusive Dune Sandworm Bucket</strong> - Xô đựng bắp tạo hình sâu cát huyền thoại cực kỳ chi tiết, đang gây bão trên toàn cầu.</p>
                    <h5 class="text-warning mt-4 mb-3">Chi tiết sản phẩm:</h5>
                    <p>Được chế tác với độ hoàn thiện cực cao, từng vảy sâu cát được mô phỏng y như thật. Miệng sâu cát là nắp mở đặc biệt, giúp việc lấy bắp trở thành một trải nghiệm độc nhất vô nhị. Không chỉ là một chiếc xô bắp, đây là một vật phẩm sưu tầm đẳng cấp dành cho người hâm mộ Dune.</p>
                    <ul class="list-group list-group-flush bg-transparent text-light mb-4">
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Sản phẩm bản quyền từ Legendary Pictures.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Bao gồm sẵn 1 phần bắp khổng lồ (Size XL).</li>
                        <li class="list-group-item bg-transparent text-light border-secondary"><i class="bi bi-check-circle-fill text-success me-2"></i>Tặng kèm 1 huy hiệu Gia tộc Atreides.</li>
                    </ul>
                    <p class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Lưu ý: Hàng đang rất khan hiếm, mỗi khách hàng chỉ được mua tối đa 2 sản phẩm.</p>
                '
            ]
        ];

        if (!isset($concessions[$slug])) {
            $this->renderError(404, 'Không tìm thấy sản phẩm');
            return;
        }

        $this->render('concessions.detail', [
            'item' => (object)$concessions[$slug],
            'pageTitle' => $concessions[$slug]['name'] . ' - CinemaX'
        ]);
    }
}
