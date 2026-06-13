<?php
// views/auth/login.php
?>
<div class="row justify-content-center py-5">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="card bg-black border border-secondary p-4 rounded shadow-lg">
            <h2 class="text-center text-warning fw-bold mb-4">ĐĂNG NHẬP</h2>

            <?php if (isset($vm->errors['general'])): ?>
                <div class="alert alert-danger border-0 p-2 text-center mb-3" style="background-color: #3b171c; color: #f8d7da;">
                    <small><?= htmlspecialchars($vm->errors['general']) ?></small>
                </div>
            <?php endif; ?>

            <form method="POST" action="/login<?= isset($_GET['redirect']) ? '?redirect='.urlencode($_GET['redirect']) : '' ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label text-light">Email</label>
                    <input type="email" name="email" 
                           class="form-control bg-dark text-light border-secondary <?= isset($vm->errors['email']) ? 'is-invalid' : '' ?>" 
                           placeholder="name@example.com" 
                           value="<?= htmlspecialchars($vm->email ?? '') ?>" required>
                    <?php if (isset($vm->errors['email'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($vm->errors['email']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label text-light">Mật khẩu</label>
                    <input type="password" name="password" 
                           class="form-control bg-dark text-light border-secondary <?= isset($vm->errors['password']) ? 'is-invalid' : '' ?>" 
                           placeholder="Mật khẩu" required>
                    <?php if (isset($vm->errors['password'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($vm->errors['password']) ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold py-2 shadow mb-3">
                    ĐĂNG NHẬP
                </button>

                <!-- OAuth Divider -->
                <div class="oauth-divider">
                    <span class="text-secondary small">hoặc đăng nhập với</span>
                </div>

                <!-- OAuth Buttons -->
                <div class="oauth-buttons">
                    <a href="/auth/google" class="btn btn-google d-flex align-items-center justify-content-center py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                        </svg>
                        Đăng nhập với Google
                    </a>
                    <a href="/auth/zalo" class="btn btn-zalo d-flex align-items-center justify-content-center py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 4.974 0 11.111c0 3.498 1.814 6.614 4.644 8.656L3.9 24l4.861-2.534c1.004.269 2.068.423 3.239.423 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm.001 20.556c-.992 0-1.95-.154-2.848-.44l-.203-.065-2.105 1.098.563-2.077-.072-.11c-1.763-2.088-2.835-4.715-2.835-7.556 0-5.297 4.477-9.611 9.5-9.611s9.5 4.314 9.5 9.611c0 5.298-4.477 9.611-9.5 9.611z"/>
                        </svg>
                        Đăng nhập với Zalo
                    </a>
                </div>

                <p class="text-center text-secondary small mb-0">
                    Chưa có tài khoản? <a href="/register" class="text-warning text-decoration-none fw-semibold">Đăng ký ngay</a>
                </p>
            </form>
        </div>
    </div>
</div>
