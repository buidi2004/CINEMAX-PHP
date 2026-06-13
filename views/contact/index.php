<?php // views/contact/index.php ?>
<div class="text-center py-5 mb-5" style="background: linear-gradient(135deg, #0a0a14, #1a1a3e, #0f0f1b); border-radius: 16px; border: 1px solid #222244;">
    <h1 class="display-5 fw-bold text-warning"><i class="bi bi-headset me-2"></i>Liên hệ & Hỗ trợ</h1>
    <p class="lead text-secondary">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card bg-dark border-0 shadow-lg h-100">
            <div class="card-body p-4">
                <h4 class="text-warning mb-4">Thông tin liên hệ</h4>
                <div class="contact-info-item d-flex gap-3 mb-4">
                    <div class="contact-icon bg-warning bg-opacity-10 rounded-circle p-3"><i class="bi bi-telephone-fill text-warning fs-4"></i></div>
                    <div><h6 class="text-light mb-1">Hotline</h6><p class="text-secondary mb-0">1900 636 018 (8:00 - 22:00)</p></div>
                </div>
                <div class="contact-info-item d-flex gap-3 mb-4">
                    <div class="contact-icon bg-primary bg-opacity-10 rounded-circle p-3"><i class="bi bi-envelope-fill text-primary fs-4"></i></div>
                    <div><h6 class="text-light mb-1">Email</h6><p class="text-secondary mb-0">support@cinemax.vn</p></div>
                </div>
                <div class="contact-info-item d-flex gap-3 mb-4">
                    <div class="contact-icon bg-success bg-opacity-10 rounded-circle p-3"><i class="bi bi-geo-alt-fill text-success fs-4"></i></div>
                    <div><h6 class="text-light mb-1">Trụ sở chính</h6><p class="text-secondary mb-0">123 Nguyễn Huệ, Q.1, TP.HCM</p></div>
                </div>
                <h6 class="text-light mt-4 mb-3">Kết nối với chúng tôi</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-primary rounded-circle" style="width:42px;height:42px;padding:0;line-height:42px;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-outline-info rounded-circle" style="width:42px;height:42px;padding:0;line-height:42px;"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="btn btn-outline-danger rounded-circle" style="width:42px;height:42px;padding:0;line-height:42px;"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-outline-danger rounded-circle" style="width:42px;height:42px;padding:0;line-height:42px;"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="btn btn-outline-secondary rounded-circle" style="width:42px;height:42px;padding:0;line-height:42px;"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card bg-dark border-0 shadow-lg">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-chat-dots me-2"></i>Gửi yêu cầu hỗ trợ</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="/contact">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label text-light">Họ và tên</label>
                            <input type="text" name="name" class="form-control bg-secondary border-0 text-light" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Email</label>
                            <input type="email" name="email" class="form-control bg-secondary border-0 text-light" placeholder="email@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-light">Chủ đề</label>
                            <select name="subject" class="form-select bg-secondary border-0 text-light">
                                <option value="booking">Vấn đề đặt vé</option>
                                <option value="payment">Thanh toán / Hoàn tiền</option>
                                <option value="account">Tài khoản</option>
                                <option value="feedback">Góp ý / Phản hồi</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-light">Nội dung</label>
                            <textarea name="message" class="form-control bg-secondary border-0 text-light" rows="5" placeholder="Mô tả chi tiết vấn đề..." required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill mt-4"><i class="bi bi-send me-1"></i>Gửi yêu cầu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FAQ -->
<div class="mt-5">
    <h4 class="text-warning fw-bold mb-4 border-start border-warning ps-3"><i class="bi bi-question-circle me-2"></i>Câu hỏi thường gặp</h4>
    <div class="accordion accordion-flush" id="faqAccordion">
        <?php
        $faqs = [
            ['q' => 'Làm sao để đặt vé online?', 'a' => 'Chọn phim → Chọn suất chiếu → Chọn ghế → Thanh toán. Quy trình chỉ mất 2-3 phút.'],
            ['q' => 'Tôi có thể hủy vé đã đặt không?', 'a' => 'Vé đã thanh toán có thể hủy trước giờ chiếu 2 tiếng. Hoàn tiền trong 3-5 ngày làm việc.'],
            ['q' => 'Mã giảm giá sử dụng như thế nào?', 'a' => 'Nhập mã giảm giá ở bước thanh toán, nhấn "Áp dụng". Hệ thống sẽ tự động tính giảm giá.'],
            ['q' => 'Quên mang vé giấy thì sao?', 'a' => 'Bạn có thể dùng vé điện tử (mã QR) trên website. Đưa mã QR cho nhân viên soát vé.'],
            ['q' => 'Tích điểm thành viên như thế nào?', 'a' => 'Mỗi lần mua vé, bạn nhận 5% giá trị dưới dạng điểm tích lũy. Đổi vé miễn phí hoặc ưu đãi.'],
        ];
        foreach ($faqs as $i => $faq): ?>
            <div class="accordion-item bg-dark border-secondary">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-dark text-light shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?= $i ?>">
                        <?= htmlspecialchars($faq['q']) ?>
                    </button>
                </h2>
                <div id="faq-<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary"><?= htmlspecialchars($faq['a']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
