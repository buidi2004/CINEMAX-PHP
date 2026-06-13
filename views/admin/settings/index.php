<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-light"><?= htmlspecialchars($pageTitle) ?></h1>
</div>

<?php require_once __DIR__ . '/../../partials/flash_message.php'; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="card bg-dark border-secondary mb-4">
                <div class="card-header border-secondary">
                    <h5 class="mb-0 text-warning"><i class="bi bi-info-circle me-2"></i>Thông tin chung</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-light">Tên Website</label>
                        <input type="text" name="site_name" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['site_name'] ?? 'CinemaX') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Mô tả Website (SEO)</label>
                        <textarea name="site_description" class="form-control bg-black text-light border-secondary" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Đoạn text Footer</label>
                        <textarea name="footer_text" class="form-control bg-black text-light border-secondary" rows="4"><?= htmlspecialchars($settings['footer_text'] ?? 'CinemaX - Trải nghiệm điện ảnh đỉnh cao.') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card bg-dark border-secondary mb-4">
                <div class="card-header border-secondary">
                    <h5 class="mb-0 text-info"><i class="bi bi-telephone me-2"></i>Liên hệ & Mạng xã hội</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Email hỗ trợ</label>
                            <input type="email" name="contact_email" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['contact_email'] ?? 'support@cinemax.com') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-light">Số điện thoại / Hotline</label>
                            <input type="text" name="contact_phone" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['contact_phone'] ?? '1900 1234') ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Địa chỉ văn phòng</label>
                        <input type="text" name="address" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['address'] ?? '123 Đường Phim, Quận Rạp, TP.HCM') ?>">
                    </div>
                    <hr class="border-secondary">
                    <div class="mb-3">
                        <label class="form-label text-light"><i class="bi bi-facebook text-primary me-2"></i>Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light"><i class="bi bi-youtube text-danger me-2"></i>YouTube URL</label>
                        <input type="url" name="youtube_url" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['youtube_url'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light"><i class="bi bi-instagram text-warning me-2"></i>Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control bg-black text-light border-secondary" value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-dark border-secondary mb-4 sticky-top" style="top: 20px;">
                <div class="card-header border-secondary">
                    <h5 class="mb-0 text-success"><i class="bi bi-image me-2"></i>Logo Website</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3 bg-black p-3 rounded border border-secondary">
                        <img src="<?= htmlspecialchars($settings['site_logo'] ?? '/assets/images/logo.png') ?>" alt="Logo" class="img-fluid" style="max-height: 100px;">
                    </div>
                    <input class="form-control bg-black text-light border-secondary mb-3" type="file" name="site_logo" accept="image/*">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold"><i class="bi bi-save me-2"></i>LƯU CẤU HÌNH</button>
                </div>
            </div>
        </div>
    </div>
</form>
