<?php // views/auth/forgot_password.php ?>
<div class="row justify-content-center min-vh-100 align-items-center">
    <div class="col-md-5 col-lg-4" data-aos="zoom-in">
        <div class="card bg-dark border-0 shadow-lg forgot-pw-card">
            <div class="card-body p-5 text-center">
                <div class="forgot-icon mb-4">
                    <i class="bi bi-envelope-check text-warning" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-light fw-bold mb-2">Quên mật khẩu?</h3>
                <p class="text-secondary mb-4">Nhập email đăng ký để nhận link đặt lại mật khẩu</p>

                <form method="POST" action="/forgot-password">
                    <?= csrf_field() ?>
                    <div class="mb-4 text-start">
                        <label class="form-label text-light">Địa chỉ email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary border-0 text-warning"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-secondary border-0 text-light" placeholder="name@example.com" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill py-2">
                        <i class="bi bi-send me-1"></i>Gửi link đặt lại
                    </button>
                </form>

                <div class="mt-4">
                    <a href="/login" class="text-warning text-decoration-none"><i class="bi bi-arrow-left me-1"></i>Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>
