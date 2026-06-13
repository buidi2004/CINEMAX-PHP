<?php
$f = '/var/www/html/views/promotions/index.php';
$c = file_get_contents($f);

// We need to remove the previous horizontal scroll container
$c = preg_replace('/<!-- Horizontal Scroll Section -->.*<\/script>/is', '', $c);

$html = <<<HTML
<!-- Horizontal Scroll Section -->
<style>
.horizontal-scroll-container {
    position: relative;
}
.horizontal-sticky {
    position: sticky;
    top: 0;
    height: 100vh;
    overflow: hidden;
    background: #f8f9fa;
}
.horizontal-track {
    display: flex;
    height: 100vh;
    width: 400vw;
    will-change: transform;
}
.horizontal-panel {
    width: 100vw;
    height: 100vh;
    flex-shrink: 0;
    overflow-y: auto; /* Allow internal scroll on smaller screens if content is too tall */
    padding-top: 80px; /* Account for navbar */
    padding-bottom: 20px;
}
@media (max-width: 991px) {
    .horizontal-scroll-container {
        height: auto !important; /* Disable scroll height */
    }
    .horizontal-sticky {
        position: relative;
        height: auto;
        overflow: visible;
    }
    .horizontal-track {
        flex-direction: column;
        width: 100%;
        height: auto;
        transform: none !important;
    }
    .horizontal-panel {
        width: 100%;
        height: auto;
        min-height: 100vh;
        padding: 100px 20px 40px;
    }
}
</style>

<div class="horizontal-scroll-container d-none d-lg-block" style="height: 400vh;">
    <div class="horizontal-sticky shadow-lg">
        <div class="horizontal-track">
            
            <!-- Panel 1 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center" style="background: #ffffff;">
                <div class="container text-center px-5">
                    <span class="badge bg-danger fs-6 mb-4 px-4 py-2 rounded-pill shadow-sm">ĐẶC QUYỀN VVIP</span>
                    <h2 class="display-3 fw-bold text-dark mb-4">Trải Nghiệm Thượng Lưu</h2>
                    <p class="lead text-secondary mx-auto" style="font-size: 1.25rem; line-height: 1.8; max-width: 800px;">
                        Chương trình thành viên độc quyền lớn nhất trong năm đã chính thức khởi động. 
                        Chúng tôi mang đến cho bạn một không gian điện ảnh vượt chuẩn mực thông thường. 
                        Hãy tận hưởng phòng chờ riêng biệt, dịch vụ ẩm thực tại ghế ngồi và lối đi ưu tiên.
                    </p>
                </div>
            </div>

            <!-- Panel 2 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center" style="background: #f1f3f5;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                            <img src="https://images.unsplash.com/photo-1585647347384-2593bc35786b?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; max-height: 60vh; width: 100%;" alt="Food">
                        </div>
                        <div class="col-lg-6 px-lg-5">
                            <h2 class="display-4 fw-bold text-dark mb-4">Ẩm Thực Đỉnh Cao</h2>
                            <p class="text-secondary fs-5 mb-4" style="line-height: 1.8;">
                                Không chỉ là bắp và nước ngọt, menu VVIP mang đến cho bạn trải nghiệm ẩm thực tinh tế chuẩn nhà hàng 5 sao. 
                                Bạn có thể thưởng thức ngay trong khi xem phim với hệ thống bàn ăn riêng biệt.
                            </p>
                            <button class="btn btn-warning btn-lg px-5 rounded-pill fw-bold shadow-sm">Xem Thực Đơn</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel 3 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center" style="background: #e9ecef;">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                            <img src="https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; max-height: 60vh; width: 100%;" alt="Gold Class">
                        </div>
                        <div class="col-lg-6 px-lg-5">
                            <h2 class="display-4 fw-bold text-dark mb-4">Phòng Gold Class</h2>
                            <p class="text-secondary fs-5 mb-4" style="line-height: 1.8;">
                                Ghế sofa da thật có thể ngả 180 độ thành giường nằm, kèm theo chăn mỏng và dép đi trong nhà. 
                                Phục vụ tại phòng chiếu với một nút bấm.
                            </p>
                            <ul class="list-unstyled text-secondary fs-5 mb-0">
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-3"></i>Màn hình OLED siêu thực</li>
                                <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-3"></i>Âm thanh vòm Dolby Atmos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel 4 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center" style="background: #212529;">
                <div class="container text-center px-3">
                    <h2 class="display-3 fw-bold text-warning mb-4">Đăng Ký VVIP</h2>
                    <p class="lead text-light mb-5 mx-auto" style="font-size: 1.25rem; line-height: 1.8; max-width: 800px;">
                        Số lượng thẻ VVIP có hạn mỗi năm. Điền thông tin ngay hôm nay để nhận bộ quà tặng gia nhập trị giá 5.000.000₫.
                    </p>
                    <form class="bg-white p-4 p-md-5 rounded-4 shadow-lg text-start mx-auto" style="max-width: 600px;">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Họ và tên</label>
                            <input type="text" class="form-control form-control-lg bg-light border-light" placeholder="Nhập họ tên của bạn">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-dark fw-bold">Số điện thoại</label>
                            <input type="tel" class="form-control form-control-lg bg-light border-light" placeholder="Nhập số điện thoại">
                        </div>
                        <button type="button" class="btn btn-warning btn-lg w-100 fw-bold py-3 rounded-pill shadow">GỬI YÊU CẦU NÂNG HẠNG</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Mobile Fallback (Vertical Scroll instead of broken horizontal) -->
<div class="d-block d-lg-none">
    <div class="py-5 bg-white text-center px-3">
        <span class="badge bg-danger fs-6 mb-3 px-4 py-2 rounded-pill">ĐẶC QUYỀN VVIP</span>
        <h2 class="display-5 fw-bold text-dark mb-3">Trải Nghiệm Thượng Lưu</h2>
        <p class="text-secondary mb-0">Chương trình thành viên độc quyền mang đến không gian điện ảnh vượt chuẩn mực thông thường.</p>
    </div>
    
    <div class="py-5 bg-light px-3">
        <img src="https://images.unsplash.com/photo-1585647347384-2593bc35786b?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-sm mb-4" alt="Food">
        <h3 class="fw-bold text-dark mb-3">Ẩm Thực Đỉnh Cao</h3>
        <p class="text-secondary mb-4">Trải nghiệm ẩm thực tinh tế chuẩn nhà hàng 5 sao ngay tại ghế ngồi bọc da cao cấp.</p>
        <button class="btn btn-warning w-100 rounded-pill fw-bold py-2">Xem Thực Đơn</button>
    </div>

    <div class="py-5 bg-white px-3">
        <img src="https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-sm mb-4" alt="Gold Class">
        <h3 class="fw-bold text-dark mb-3">Phòng Gold Class</h3>
        <p class="text-secondary mb-4">Ghế sofa ngả 180 độ, âm thanh vòm đỉnh cao và màn hình OLED siêu thực.</p>
        <ul class="list-unstyled text-secondary">
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Màn hình OLED Laser</li>
            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Âm thanh vòm 360 độ</li>
        </ul>
    </div>

    <div class="py-5 bg-dark px-3 text-center">
        <h3 class="fw-bold text-warning mb-3">Đăng Ký VVIP</h3>
        <p class="text-light mb-4">Điền thông tin ngay hôm nay để nhận bộ quà tặng gia nhập trị giá 5.000.000₫.</p>
        <form class="bg-white p-4 rounded-4 text-start">
            <div class="mb-3">
                <input type="text" class="form-control bg-light border-0" placeholder="Họ và tên">
            </div>
            <div class="mb-4">
                <input type="tel" class="form-control bg-light border-0" placeholder="Số điện thoại">
            </div>
            <button type="button" class="btn btn-warning w-100 fw-bold py-2 rounded-pill">GỬI YÊU CẦU</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('scroll', function() {
    if (window.innerWidth < 992) return; // Disable JS on mobile where it is hidden anyway
    
    const container = document.querySelector('.horizontal-scroll-container.d-lg-block');
    const track = container ? container.querySelector('.horizontal-track') : null;
    
    if (!container || !track) return;

    const rect = container.getBoundingClientRect();
    const stickyHeight = window.innerHeight;
    
    const scrollableDistance = rect.height - stickyHeight;
    let scrolled = -rect.top;
    
    if (scrolled < 0) {
        track.style.transform = 	ranslateX(0vw);
    } else if (scrolled > scrollableDistance) {
        track.style.transform = 	ranslateX(-300vw);
    } else {
        let progress = scrolled / scrollableDistance;
        let translateValue = progress * 300; 
        track.style.transform = 	ranslateX(- + translateValue + w);
    }
});
</script>
HTML;

file_put_contents($f, $c . "\n" . $html);
echo "Fixed UX";
