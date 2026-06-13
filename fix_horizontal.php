<?php
$f = '/var/www/html/views/promotions/index.php';
$c = file_get_contents($f);

$html = <<<HTML

<!-- Horizontal Scroll Section -->
<div class="horizontal-scroll-container" style="height: 400vh; position: relative;">
    <div class="horizontal-sticky" style="position: sticky; top: 0; height: 100vh; overflow: hidden; background: #f8f9fa;">
        
        <!-- Track that moves horizontally -->
        <div class="horizontal-track d-flex" style="width: 400vw; height: 100vh;">
            
            <!-- Panel 1 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center position-relative" style="width: 100vw; height: 100vh; background: #ffffff;">
                <div class="container text-center">
                    <span class="badge bg-danger fs-6 mb-3 px-4 py-2 rounded-pill shadow-sm">ĐẶC QUYỀN VVIP</span>
                    <h2 class="display-3 fw-bold text-dark mb-4">Trải Nghiệm Thượng Lưu</h2>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p class="lead text-secondary" style="font-size: 1.25rem; line-height: 1.8;">
                                Chương trình thành viên độc quyền lớn nhất trong năm đã chính thức khởi động. 
                                Chúng tôi mang đến cho bạn một không gian điện ảnh vượt chuẩn mực thông thường. 
                                Hãy tận hưởng phòng chờ riêng biệt, dịch vụ ẩm thực tại ghế ngồi và lối đi ưu tiên. 
                                Cuộn xuống để tiếp tục hành trình khám phá những đặc quyền dành riêng cho bạn.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel 2 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center position-relative" style="width: 100vw; height: 100vh; background: #f1f3f5;">
                <div class="row w-100 align-items-center px-5">
                    <div class="col-md-6 px-5">
                        <img src="https://images.unsplash.com/photo-1585647347384-2593bc35786b?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg w-100" style="object-fit: cover; height: 60vh;" alt="Food">
                    </div>
                    <div class="col-md-6 px-5">
                        <h2 class="display-4 fw-bold text-dark mb-4">Ẩm Thực Đỉnh Cao</h2>
                        <p class="text-secondary fs-5 mb-4" style="line-height: 1.8;">
                            Không chỉ là bắp và nước ngọt, menu VVIP mang đến cho bạn trải nghiệm ẩm thực tinh tế chuẩn nhà hàng 5 sao. 
                            Các set menu được chế biến bởi bếp trưởng danh tiếng, đi kèm danh sách rượu vang hảo hạng. 
                            Bạn có thể thưởng thức ngay trong khi xem phim với hệ thống bàn ăn riêng biệt được tích hợp ngay tại ghế ngồi bọc da cao cấp.
                        </p>
                        <button class="btn btn-warning btn-lg px-5 rounded-pill fw-bold">Xem Thực Đơn</button>
                    </div>
                </div>
            </div>

            <!-- Panel 3 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center position-relative" style="width: 100vw; height: 100vh; background: #e9ecef;">
                <div class="row w-100 align-items-center px-5 flex-row-reverse">
                    <div class="col-md-6 px-5">
                        <img src="https://images.unsplash.com/photo-1595769816263-9b910be24d5f?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg w-100" style="object-fit: cover; height: 60vh;" alt="Gold Class">
                    </div>
                    <div class="col-md-6 px-5">
                        <h2 class="display-4 fw-bold text-dark mb-4">Phòng Chiếu Gold Class</h2>
                        <p class="text-secondary fs-5 mb-4" style="line-height: 1.8;">
                            Mỗi phòng chiếu chỉ giới hạn 20 ghế ngồi nhằm đảm bảo không gian riêng tư tuyệt đối. 
                            Ghế sofa da thật có thể ngả 180 độ thành giường nằm, kèm theo chăn mỏng và dép đi trong nhà. 
                            Đội ngũ nhân viên phục vụ tại phòng chiếu luôn sẵn sàng đáp ứng mọi yêu cầu của bạn chỉ với một nút bấm gọi dịch vụ.
                        </p>
                        <ul class="list-unstyled text-secondary fs-5 mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-3"></i>Màn hình OLED Laser siêu thực</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-3"></i>Âm thanh vòm Dolby Atmos 360 độ</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-3"></i>Hệ thống lọc không khí y tế</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Panel 4 -->
            <div class="horizontal-panel d-flex align-items-center justify-content-center position-relative" style="width: 100vw; height: 100vh; background: #212529;">
                <div class="container text-center">
                    <h2 class="display-3 fw-bold text-warning mb-4">Đăng Ký Nâng Hạng VVIP</h2>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p class="lead text-light mb-5" style="font-size: 1.25rem; line-height: 1.8;">
                                Số lượng thẻ VVIP được phát hành có hạn mỗi năm. Đừng bỏ lỡ cơ hội gia nhập cộng đồng điện ảnh đẳng cấp nhất. 
                                Điền thông tin ngay hôm nay để nhận bộ quà tặng gia nhập trị giá 5.000.000₫.
                            </p>
                            <form class="bg-white p-5 rounded-4 shadow-lg text-start">
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-bold">Họ và tên</label>
                                    <input type="text" class="form-control form-control-lg bg-light border-light" placeholder="Nhập họ tên của bạn">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-bold">Số điện thoại</label>
                                    <input type="tel" class="form-control form-control-lg bg-light border-light" placeholder="Nhập số điện thoại">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label text-dark fw-bold">Email liên hệ</label>
                                    <input type="email" class="form-control form-control-lg bg-light border-light" placeholder="Nhập email">
                                </div>
                                <button type="button" class="btn btn-warning btn-lg w-100 fw-bold py-3 rounded-pill">GỬI YÊU CẦU NÂNG HẠNG</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('scroll', function() {
    const container = document.querySelector('.horizontal-scroll-container');
    const track = document.querySelector('.horizontal-track');
    
    if (!container || !track) return;

    const rect = container.getBoundingClientRect();
    const stickyHeight = window.innerHeight;
    
    // Total scrollable distance = Container height - Viewport height
    const scrollableDistance = rect.height - stickyHeight;
    
    // Distance scrolled inside the container
    let scrolled = -rect.top;
    
    if (scrolled < 0) {
        // Not reached the container yet
        track.style.transform = 	ranslateX(0vw);
    } else if (scrolled > scrollableDistance) {
        // Passed the container
        track.style.transform = 	ranslateX(-300vw); // 4 panels -> 3 shifts of 100vw
    } else {
        // Scrolling inside the container
        let progress = scrolled / scrollableDistance; // 0 to 1
        let translateValue = progress * 300; // max 300vw translation
        track.style.transform = 	ranslateX(- + translateValue + w);
    }
});
</script>

HTML;

file_put_contents($f, $c . "\n" . $html);
echo "Done";
