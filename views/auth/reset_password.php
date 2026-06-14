<?php // views/auth/reset_password.php ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body p-5">
                <h2 class="text-center mb-4 fw-bold">Đặt lại mật khẩu</h2>
                
                <?php if ($error = \App\Core\Session::getFlash('error')): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" action="/reset-password">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(\App\Core\Session::get('csrf_token')) ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-secondary fw-semibold">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light border-0" required minlength="6">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-semibold">Nhập lại mật khẩu</label>
                        <input type="password" name="confirm_password" class="form-control form-control-lg bg-light border-0" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">Xác nhận Đổi Mật Khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
