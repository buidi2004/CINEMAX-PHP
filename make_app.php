<?php

// 1. Update config/routes.php
$routesFile = '/var/www/html/config/routes.php';
$routes = file_get_contents($routesFile);
if (strpos($routes, '/app') === false) {
    $routes = str_replace(
        "$router->get('/',                         'HomeController@index');",
        "$router->get('/',                         'HomeController@index');\n$router->get('/app',                       'HomeController@app');",
        $routes
    );
    file_put_contents($routesFile, $routes);
}

// 2. Update HomeController.php
$homeCtrlFile = '/var/www/html/app/Controllers/HomeController.php';
$homeCtrl = file_get_contents($homeCtrlFile);
if (strpos($homeCtrl, 'public function app()') === false) {
    $method = <<<PHP

    public function app() {
        \->render('home/app', ['title' => 'CinemaX App']);
    }
}
PHP;
    // Replace the last closing brace with the new method and a closing brace
    $homeCtrl = preg_replace('/}(?!.*})/', $method, $homeCtrl);
    file_put_contents($homeCtrlFile, $homeCtrl);
}

// 3. Create views/home/app.php
$appView = <<<HTML
<?php // views/home/app.php ?>
<div class="app-landing" style="overflow-x: hidden;">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px; margin-top: -2rem;">
        <div class="col-lg-6 p-5 text-center text-lg-start" data-aos="fade-right">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">PHIÊN BẢN MỚI 2.0</span>
            <h1 class="display-3 fw-bold text-dark mb-4">Trải nghiệm điện ảnh trong tầm tay</h1>
            <p class="lead text-secondary mb-5">
                Ứng dụng CinemaX App mang đến trải nghiệm đặt vé siêu tốc, thanh toán một chạm, 
                và tích điểm thành viên hoàn toàn tự động. Tải ngay để nhận voucher 50K cho lần đăng nhập đầu tiên!
            </p>
            <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                <a href="#" class="btn btn-dark btn-lg rounded-pill px-4 py-3 shadow-lg d-flex align-items-center">
                    <i class="bi bi-apple fs-3 me-3"></i>
                    <div class="text-start">
                        <small class="d-block text-secondary" style="font-size: 0.7rem; line-height: 1;">Tải trên</small>
                        <span class="fw-bold">App Store</span>
                    </div>
                </a>
                <a href="#" class="btn btn-dark btn-lg rounded-pill px-4 py-3 shadow-lg d-flex align-items-center">
                    <i class="bi bi-google-play fs-3 me-3"></i>
                    <div class="text-start">
                        <small class="d-block text-secondary" style="font-size: 0.7rem; line-height: 1;">Tải trên</small>
                        <span class="fw-bold">Google Play</span>
                    </div>
                </a>
            </div>
            
            <div class="mt-5 d-flex align-items-center justify-content-center justify-content-lg-start gap-4">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://cinemax.com/app" class="img-thumbnail rounded-4 shadow-sm" alt="QR Code">
                <div>
                    <h6 class="fw-bold text-dark mb-1">Quét mã QR</h6>
                    <p class="text-secondary small mb-0">Sử dụng camera điện thoại để tải ứng dụng ngay lập tức.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 text-center position-relative" data-aos="fade-left">
            <div class="position-absolute top-50 start-50 translate-middle w-75 h-75 bg-warning rounded-circle opacity-25" style="filter: blur(80px);"></div>
            <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=600&auto=format&fit=crop" class="img-fluid rounded-5 shadow-lg border border-5 border-white" style="transform: rotate(-5deg); max-height: 600px;" alt="CinemaX App UI">
        </div>
    </div>

    <!-- Features -->
    <div class="py-5 mb-5 text-center">
        <h2 class="display-5 fw-bold text-dark mb-5">Tính Năng Nổi Bật</h2>
        <div class="row g-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-light transition-all hover-shadow">
                    <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="bi bi-lightning-charge fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Đặt Vé Siêu Tốc 3s</h4>
                    <p class="text-secondary">Chỉ với 3 thao tác chạm, bạn đã có thể giữ chỗ ngồi yêu thích cho bộ phim mong đợi nhất mà không cần xếp hàng.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-light transition-all hover-shadow">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="bi bi-wallet2 fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Ví Kỹ Thuật Số</h4>
                    <p class="text-secondary">Tích hợp đa dạng phương thức thanh toán: Momo, ZaloPay, VNPay, và đặc biệt là hệ thống điểm thành viên tự động khấu trừ.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 border border-light transition-all hover-shadow">
                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-sm" style="width: 80px; height: 80px;">
                        <i class="bi bi-ticket-perforated fs-1"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Vé Điện Tử Tiện Lợi</h4>
                    <p class="text-secondary">Không cần in vé giấy. Quét trực tiếp mã QR trên ứng dụng tại cổng soát vé và quầy bắp nước cực kỳ nhanh chóng.</p>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;
file_put_contents('/var/www/html/views/home/app.php', $appView);

// 4. Link the banner in home/index.php
$homeView = '/var/www/html/views/home/index.php';
$c = file_get_contents($homeView);
$c = str_replace(
    '<!-- #10 T?i ?ng D?ng (App Download) - NEW SECTION -->',
    '<!-- #10 T?i ?ng D?ng (App Download) -->',
    $c
);
$c = str_replace(
    '<button class="btn btn-outline-dark rounded-pill px-4 py-2 fs-5"><i class="bi bi-apple me-2"></i>App Store</button>',
    '<a href="/app" class="btn btn-outline-dark rounded-pill px-4 py-2 fs-5 text-decoration-none"><i class="bi bi-apple me-2"></i>App Store</a>',
    $c
);
$c = str_replace(
    '<button class="btn btn-outline-dark rounded-pill px-4 py-2 fs-5"><i class="bi bi-google-play me-2"></i>Google Play</button>',
    '<a href="/app" class="btn btn-outline-dark rounded-pill px-4 py-2 fs-5 text-decoration-none"><i class="bi bi-google-play me-2"></i>Google Play</a>',
    $c
);

file_put_contents($homeView, $c);
echo "Created app detail page";
