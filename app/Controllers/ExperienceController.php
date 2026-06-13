<?php
namespace App\Controllers;

use App\Core\Container;

class ExperienceController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function detail(string $slug): void
    {
        // Mock data for experiences
        $experiences = [
            'dolby-atmos' => [
                'name' => 'Âm Thanh Dolby Atmos',
                'slogan' => 'Cảm nhận từng nhịp đập, đắm chìm trong không gian 3D',
                'image' => 'https://images.unsplash.com/photo-1598899134739-24c46f58b8c0?q=80&w=1200&auto=format&fit=crop',
                'video' => 'https://www.youtube.com/embed/O-AhiV0XU8w?autoplay=1&mute=1&loop=1&playlist=O-AhiV0XU8w',
                'description' => '
                    <p class="fs-4 text-light fw-bold">Bước ngoặt vĩ đại nhất trong lịch sử âm thanh điện ảnh kể từ khi âm thanh vòm ra đời.</p>
                    <p class="fs-5 text-secondary mb-5">Hệ thống âm thanh Dolby Atmos® vận hành thông qua việc đưa âm thanh di chuyển tự do mọi hướng trong không gian rạp 3 chiều. Đây là sự đột phá vượt bậc so với hệ thống âm thanh kênh (channel-based) truyền thống.</p>
                    
                    <h3 class="text-warning mb-4">Sự khác biệt của Dolby Atmos</h3>
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="card bg-dark border-secondary h-100 p-4">
                                <i class="bi bi-speaker fs-1 text-info mb-3"></i>
                                <h5 class="text-white">Âm thanh đa chiều</h5>
                                <p class="text-secondary small">Âm thanh không chỉ phát ra từ các hướng xung quanh mà còn xuất hiện ngay trên đỉnh đầu bạn (overhead), mang lại cảm giác chân thực đến khó tin.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-dark border-secondary h-100 p-4">
                                <i class="bi bi-music-note-beamed fs-1 text-info mb-3"></i>
                                <h5 class="text-white">Chi tiết kinh ngạc</h5>
                                <p class="text-secondary small">Mỗi âm thanh là một "thực thể" độc lập (object-based), từ tiếng lá rơi xào xạc đến tiếng gầm rú của phi thuyền, tất cả đều trong trẻo và tách bạch.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-dark border-secondary h-100 p-4">
                                <i class="bi bi-heart-pulse fs-1 text-info mb-3"></i>
                                <h5 class="text-white">Cảm xúc bùng nổ</h5>
                                <p class="text-secondary small">Khơi dậy mạnh mẽ mọi giác quan, khiến bạn có cảm giác như mình đang đứng ngay giữa trung tâm của bối cảnh bộ phim.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning bg-transparent border-warning text-light p-4">
                        <h5 class="fw-bold"><i class="bi bi-star-fill text-warning me-2"></i>Trải nghiệm ngay tại CinemaX</h5>
                        <p class="mb-0">Hơn 50 phòng chiếu tại hệ thống CinemaX toàn quốc đã được trang bị công nghệ Dolby Atmos, tối ưu hóa bởi các chuyên gia âm thanh hàng đầu. Hãy chọn vé xem phim có biểu tượng <span class="badge bg-success">ATMOS</span> để thưởng thức.</p>
                    </div>
                '
            ],
            'imax' => [
                'name' => 'Màn Hình IMAX Khổng Lồ',
                'slogan' => 'Đừng chỉ xem phim. Hãy là một phần của bộ phim.',
                'image' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1200&auto=format&fit=crop',
                'video' => 'https://www.youtube.com/embed/lWeEihI7B6E?autoplay=1&mute=1&loop=1&playlist=lWeEihI7B6E',
                'description' => '
                    <p class="fs-4 text-light fw-bold">Chuẩn mực cao nhất của trải nghiệm thị giác điện ảnh.</p>
                    <p class="fs-5 text-secondary mb-5">Từ những bộ phim bom tấn Hollywood được quay hoàn toàn bằng máy quay IMAX®, đến thiết kế phòng chiếu hình vòm bọc trọn tầm nhìn, IMAX® mang đến hình ảnh rực rỡ, độ phân giải sắc nét tối đa và kích thước khổng lồ.</p>
                    
                    <h3 class="text-warning mb-4">Các yếu tố tạo nên IMAX®</h3>
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="card bg-dark border-secondary h-100 p-4">
                                <i class="bi bi-camera-reels fs-1 text-info mb-3"></i>
                                <h5 class="text-white">Máy quay IMAX</h5>
                                <p class="text-secondary small">Máy quay phim có độ phân giải cao nhất thế giới. Đạo diễn sử dụng máy quay IMAX để bắt trọn những khung hình mở rộng với tỷ lệ khung hình độc quyền (Aspect Ratio 1.90:1 hoặc 1.43:1).</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-dark border-secondary h-100 p-4">
                                <i class="bi bi-display fs-1 text-info mb-3"></i>
                                <h5 class="text-white">Hệ thống máy chiếu kép</h5>
                                <p class="text-secondary small">IMAX sử dụng hai máy chiếu 4K laser hoạt động song song để mang lại hình ảnh có độ sáng vượt trội, độ tương phản tuyệt đối và dải màu phong phú chưa từng có.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-dark border-secondary h-100 p-4">
                                <i class="bi bi-aspect-ratio fs-1 text-info mb-3"></i>
                                <h5 class="text-white">Thiết kế phòng chiếu</h5>
                                <p class="text-secondary small">Màn hình cong khổng lồ được thiết kế vát góc tối ưu. Chỗ ngồi được bố trí dạng sân vận động, đảm bảo góc nhìn hoàn hảo ở mọi vị trí.</p>
                            </div>
                        </div>
                    </div>
                '
            ],
            'sweetbox' => [
                'name' => 'Ghế Đôi Sweetbox',
                'slogan' => 'Riêng tư tuyệt đối, trọn vẹn yêu thương',
                'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=1200&auto=format&fit=crop',
                'video' => 'https://www.youtube.com/embed/Yv1u-6r4OTo?autoplay=1&mute=1&loop=1&playlist=Yv1u-6r4OTo', // Placeholder cozy vibes video
                'description' => '
                    <p class="fs-4 text-light fw-bold">Không gian lãng mạn dành riêng cho hai người.</p>
                    <p class="fs-5 text-secondary mb-5">Sweetbox là hàng ghế đặc biệt được bố trí ở cuối phòng chiếu, trang bị vách ngăn cao cấp cùng thiết kế ghế dính liền loại bỏ tựa tay ở giữa, tạo nên không gian hoàn toàn riêng tư cho các cặp đôi.</p>
                    
                    <h3 class="text-warning mb-4">Đặc điểm nổi bật của Sweetbox</h3>
                    <ul class="list-group list-group-flush bg-transparent text-light mb-5">
                        <li class="list-group-item bg-transparent text-light border-secondary py-3"><i class="bi bi-heart-fill text-danger me-3 fs-5"></i><strong>Gần gũi hơn bao giờ hết:</strong> Lược bỏ tay vịn ở giữa giúp hai người có thể ngồi sát bên nhau thoải mái, tựa vai dễ dàng.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary py-3"><i class="bi bi-shield-lock-fill text-danger me-3 fs-5"></i><strong>Riêng tư tuyệt đối:</strong> Vách ngăn che chắn hai bên và phía sau rất cao, hạn chế tối đa sự ảnh hưởng từ những người xung quanh.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary py-3"><i class="bi bi-star-fill text-danger me-3 fs-5"></i><strong>Chất liệu êm ái:</strong> Đệm ghế bọc da PU cao cấp siêu mềm, kích thước ghế rộng rãi hơn so với ghế thông thường.</li>
                        <li class="list-group-item bg-transparent text-light border-secondary py-3"><i class="bi bi-eye-fill text-danger me-3 fs-5"></i><strong>Góc nhìn trọn vẹn:</strong> Vị trí lý tưởng nhất ở cuối hàng, giúp bao quát toàn bộ màn hình một cách hoàn hảo mà không bị mỏi cổ.</li>
                    </ul>
                    
                    <div class="text-center">
                        <a href="/movies" class="btn btn-warning btn-lg rounded-pill fw-bold px-5">ĐẶT VÉ SWEETBOX NGAY</a>
                    </div>
                '
            ]
        ];

        if (!isset($experiences[$slug])) {
            $this->renderError(404, 'Không tìm thấy trải nghiệm');
            return;
        }

        $this->render('experiences.detail', [
            'item' => (object)$experiences[$slug],
            'pageTitle' => $experiences[$slug]['name'] . ' - CinemaX'
        ]);
    }
}
