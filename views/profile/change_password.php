<?php // views/profile/change_password.php ?>
<div class="row justify-content-center">
    <div class="col-lg-5" data-aos="zoom-in">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/profile" class="text-warning text-decoration-none">Hồ sơ</a></li>
                <li class="breadcrumb-item active text-secondary">Đổi mật khẩu</li>
            </ol>
        </nav>
        <div class="card bg-dark border-0 shadow-lg">
            <div class="card-header bg-black border-bottom border-secondary">
                <h4 class="mb-0 text-warning"><i class="bi bi-shield-lock me-2"></i>Đổi mật khẩu</h4>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($vm->errors['general'])): ?>
                    <div class="alert alert-danger border-0"><i class="bi bi-exclamation-triangle me-1"></i><?= htmlspecialchars($vm->errors['general']) ?></div>
                <?php endif; ?>
                <form method="POST" action="/profile/change-password">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label text-light">Mật khẩu hiện tại</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control bg-secondary border-0 text-light" id="current-pw" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current-pw')"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Mật khẩu mới</label>
                        <div class="input-group">
                            <input type="password" name="new_password" class="form-control bg-secondary border-0 text-light" id="new-pw" required minlength="8" oninput="checkPasswordStrength(this.value)">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new-pw')"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="mt-2">
                            <div class="progress bg-secondary" style="height: 4px;">
                                <div class="progress-bar" id="pw-strength-bar" style="width: 0%"></div>
                            </div>
                            <small id="pw-strength-text" class="text-secondary mt-1 d-block"></small>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-light">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" class="form-control bg-secondary border-0 text-light" required minlength="8">
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-pill"><i class="bi bi-check-lg me-1"></i>Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function togglePassword(id) { const i = document.getElementById(id); i.type = i.type === 'password' ? 'text' : 'password'; }
function checkPasswordStrength(pw) {
    let s = 0;
    if (pw.length >= 8) s++;
    if (/[A-Z]/.test(pw)) s++;
    if (/[0-9]/.test(pw)) s++;
    if (/[^A-Za-z0-9]/.test(pw)) s++;
    const bar = document.getElementById('pw-strength-bar');
    const text = document.getElementById('pw-strength-text');
    const levels = [{w:'25%',c:'bg-danger',l:'Yếu'},{w:'50%',c:'bg-warning',l:'Trung bình'},{w:'75%',c:'bg-info',l:'Khá'},{w:'100%',c:'bg-success',l:'Mạnh'}];
    const lv = levels[Math.min(s, 3)];
    bar.style.width = pw.length === 0 ? '0%' : lv.w;
    bar.className = 'progress-bar ' + lv.c;
    text.textContent = pw.length === 0 ? '' : lv.l;
}
</script>
