<?php
// views/profile/edit.php
use App\Core\Session;
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6" data-aos="fade-up">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/profile" class="text-warning text-decoration-none">Hồ sơ</a></li>
                <li class="breadcrumb-item active text-secondary">Chỉnh sửa</li>
            </ol>
        </nav>

        <div class="card bg-dark border-0 shadow-lg">
            <div class="card-header bg-black border-bottom border-secondary">
                <h4 class="mb-0 text-warning"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa hồ sơ</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="/profile/edit" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="text-center mb-4">
                        <div class="avatar-upload-wrapper position-relative d-inline-block">
                            <img src="<?= htmlspecialchars($user->avatar_url ?: '/assets/images/default-avatar.png') ?>"
                                 class="rounded-circle border border-3 border-warning"
                                 id="avatar-preview" width="120" height="120" style="object-fit: cover;" alt="Avatar"
                                 onerror="this.src='/assets/images/default-avatar.png'">
                            <label for="avatar-input"
                                   class="btn btn-sm btn-warning rounded-circle position-absolute bottom-0 end-0"
                                   style="width:36px; height:36px; padding:0; line-height:36px;">
                                <i class="bi bi-camera"></i>
                            </label>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*" class="d-none"
                                   onchange="previewAvatar(this)">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label text-light">Họ và tên</label>
                            <input type="text" name="full_name" class="form-control bg-secondary border-0 text-light"
                                   value="<?= htmlspecialchars($user->full_name ?? '') ?>" placeholder="Nguyễn Văn A">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Tên đăng nhập</label>
                            <input type="text" class="form-control bg-secondary border-0 text-secondary"
                                   value="<?= htmlspecialchars($user->username) ?>" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Email</label>
                            <input type="email" class="form-control bg-secondary border-0 text-secondary"
                                   value="<?= htmlspecialchars($user->email) ?>" readonly>
                            <small class="text-secondary">Liên hệ admin để đổi email</small>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control bg-secondary border-0 text-light"
                                   value="<?= htmlspecialchars($user->phone ?? '') ?>" placeholder="0901234567">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Ngày sinh</label>
                            <input type="date" name="date_of_birth" class="form-control bg-secondary border-0 text-light"
                                   value="<?= htmlspecialchars($user->date_of_birth ?? '') ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Giới tính</label>
                            <select name="gender" class="form-select bg-secondary border-0 text-light">
                                <option value="male"   <?= ($user->gender ?? '') === 'male'   ? 'selected' : '' ?>>Nam</option>
                                <option value="female" <?= ($user->gender ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
                                <option value="other"  <?= ($user->gender ?? '') === 'other'  ? 'selected' : '' ?>>Khác</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-light">Thành phố</label>
                            <select name="city" class="form-select bg-secondary border-0 text-light">
                                <option value="">-- Chọn thành phố --</option>
                                <?php
                                $cities = ['TP. Hồ Chí Minh','Hà Nội','Đà Nẵng','Cần Thơ','Hải Phòng','Nha Trang','Huế','Biên Hòa','Vũng Tàu','Đà Lạt'];
                                foreach ($cities as $city):
                                ?>
                                    <option value="<?= $city ?>" <?= ($user->city ?? '') === $city ? 'selected' : '' ?>><?= $city ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning rounded-pill px-4">
                            <i class="bi bi-check-lg me-1"></i>Lưu thay đổi
                        </button>
                        <a href="/profile" class="btn btn-outline-secondary rounded-pill px-4">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => { document.getElementById('avatar-preview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
