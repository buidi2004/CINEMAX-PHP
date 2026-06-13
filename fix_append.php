<?php
// Append Cinemas
$f = '/var/www/html/views/cinemas/index.php';
$c = file_get_contents($f);
$html = <<<HTML
<!-- Bảng Giá Vé Tham Khảo -->
<div class="mt-5 pt-5 border-top border-light" data-aos="fade-up">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark mb-3"><i class="bi bi-ticket-perforated text-warning me-2"></i>Bảng Giá Vé Tham Khảo</h2>
        <p class="text-secondary">Giá vé có thể thay đổi tùy theo rạp, khung giờ và ngày lễ tết.</p>
    </div>
    <div class="row g-4 justify-content-center">
        <!-- 2D Ticket -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-light bg-white shadow-sm h-100 text-center hover-shadow transition-all">
                <div class="card-header bg-light border-light py-4"><h4 class="fw-bold text-dark mb-0">Vé 2D Tiêu Chuẩn</h4></div>
                <div class="card-body py-4">
                    <h2 class="display-5 fw-bold text-warning mb-4">65.000<small class="fs-5 text-secondary">₫</small></h2>
                    <ul class="list-unstyled text-secondary text-start mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Thứ 2 - Thứ 5</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Trước 17:00</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ghế thường/VIP</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 3D Ticket -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-warning bg-white shadow-lg h-100 text-center position-relative" style="transform: scale(1.05); z-index: 2;">
                <div class="position-absolute top-0 start-50 translate-middle"><span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">PHỔ BIẾN NHẤT</span></div>
                <div class="card-header bg-warning py-4 border-warning"><h4 class="fw-bold text-dark mb-0">Vé Cuối Tuần / Lễ</h4></div>
                <div class="card-body py-4">
                    <h2 class="display-5 fw-bold text-dark mb-4">95.000<small class="fs-5 text-secondary">₫</small></h2>
                    <ul class="list-unstyled text-secondary text-start mx-auto" style="max-width: 200px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Thứ 6 - Chủ Nhật</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ngày Lễ / Tết</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ghế thường/VIP</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quy định rạp chiếu phim -->
<div class="mt-5 pt-5 mb-5 border-top border-light" data-aos="fade-up">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0"><img src="https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" alt="Cinema Rules"></div>
        <div class="col-lg-6 px-lg-5">
            <h2 class="fw-bold text-dark mb-4">Quy Định Chung Tại Rạp</h2>
            <div class="d-flex mb-4">
                <div class="me-3"><div class="bg-light text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;"><i class="bi bi-camera-video-off fs-4"></i></div></div>
                <div><h5 class="fw-bold text-dark mb-1">Không Quay Phim / Chụp Ảnh</h5><p class="text-secondary mb-0">Nghiêm cấm mọi hành vi ghi âm, ghi hình trong phòng chiếu.</p></div>
            </div>
        </div>
    </div>
</div>
HTML;
file_put_contents($f, $c . "\n" . $html);

// Append Home Zoom
$f = '/var/www/html/views/home/index.php';
$c = file_get_contents($f);
$html = <<<HTML
<!-- Scale on Scroll Section -->
<div class="scroll-zoom-wrapper mt-5" style="height: 250vh; position: relative;">
    <div class="sticky-top" style="height: 100vh; overflow: hidden; position: sticky; top: 0; display: flex; align-items: center; justify-content: center; background: #000;">
        <img src="https://images.unsplash.com/photo-1626814026160-2237a95fc5a0?q=80&w=1920&auto=format&fit=crop" id="zoomImage" style="width: 100vw; height: 100vh; object-fit: cover; transform-origin: center center; transition: transform 0.1s ease-out; filter: brightness(0.6);" alt="Featured">
        <div class="position-absolute text-center text-white p-4 w-100" style="z-index: 10; pointer-events: none;">
            <span class="badge bg-warning text-dark fs-5 px-4 py-2 mb-3 rounded-pill shadow-lg">TIN ĐỘC QUYỀN</span>
            <h1 class="display-3 fw-bold mb-4" style="text-shadow: 2px 2px 20px rgba(0,0,0,0.9);">VŨ TRỤ ĐIỆN ẢNH MỞ RỘNG</h1>
            <p class="lead fs-4 fw-light mx-auto" style="max-width: 800px; text-shadow: 1px 1px 10px rgba(0,0,0,0.8);">Cuộn chuột xuống để tiến vào tâm điểm của kỷ nguyên giải trí mới.</p>
        </div>
    </div>
</div>
<script>
document.addEventListener('scroll', function() {
    const wrapper = document.querySelector('.scroll-zoom-wrapper');
    if(!wrapper) return;
    const rect = wrapper.getBoundingClientRect();
    let scrollPercent = 0;
    if (rect.top <= 0) {
        const maxScroll = rect.height - window.innerHeight;
        scrollPercent = Math.abs(rect.top) / maxScroll;
        if (scrollPercent > 1) scrollPercent = 1;
    }
    const scale = 1 + (scrollPercent * 1.0);
    const img = document.getElementById('zoomImage');
    if(img) img.style.transform = 'scale(' + scale + ')';
});
</script>
HTML;
file_put_contents($f, str_replace("</style>", "</style>\n" . $html, $c));
