<?php
// views/profile/index.php
use App\Core\Session;
?>

<div class="row g-4">
    <!-- Cột trái: Thẻ hồ sơ chính -->
    <div class="col-lg-4" data-aos="fade-right">
        <div class="card profile-main-card border-0 overflow-hidden">
            <div class="profile-header position-relative text-center py-5"
                 style="background: linear-gradient(135deg, #0f0f1b 0%, #1a1a3e 50%, #2d1f6e 100%);">
                <div class="avatar-wrapper mx-auto mb-3 position-relative">
                    <img src="<?= htmlspecialchars($user->avatar_url ?: '/assets/images/default-avatar.png') ?>"
                         class="rounded-circle border border-3 border-warning avatar-glow"
                         width="120" height="120" alt="Avatar" style="object-fit: cover;"
                         onerror="this.src='/assets/images/default-avatar.png'">
                    <?php
                    $ml = $user->member_level ?? 'bronze';
                    $badgeClass = match($ml) {
                        'diamond' => 'bg-info',
                        'gold'    => 'bg-warning text-dark',
                        'silver'  => 'bg-secondary',
                        default   => 'bg-danger',
                    };
                    ?>
                    <span class="badge member-badge position-absolute bottom-0 start-50 translate-middle-x <?= $badgeClass ?> rounded-pill px-3">
                        <i class="bi bi-gem me-1"></i><?= ucfirst($ml) ?>
                    </span>
                </div>

                <h4 class="text-light fw-bold mb-1">
                    <?= htmlspecialchars($user->full_name ?: $user->username) ?>
                </h4>
                <p class="text-secondary mb-0">
                    <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($user->email) ?>
                </p>
            </div>

            <div class="card-body bg-dark p-4">
                <div class="row g-3 text-center mb-4">
                    <div class="col-4">
                        <div class="stat-mini p-2 rounded-3">
                            <div class="text-warning fw-bold fs-5"><?= $stats->total_tickets ?? 0 ?></div>
                            <small class="text-secondary">Vé đã mua</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-mini p-2 rounded-3">
                            <div class="text-warning fw-bold fs-5"><?= $stats->total_movies ?? 0 ?></div>
                            <small class="text-secondary">Phim đã xem</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-mini p-2 rounded-3">
                            <div class="text-warning fw-bold fs-5"><?= number_format($user->loyalty_points ?? 0) ?></div>
                            <small class="text-secondary">Điểm</small>
                        </div>
                    </div>
                </div>

                <!-- Thẻ Thành Viên (Tier Card 3D) -->
                <div class="tier-card-3d mb-4" style="perspective: 1000px;" data-aos="zoom-in" data-aos-delay="200">
                    <div class="tier-card-inner position-relative rounded-4 p-3 shadow-lg"
                         style="background: linear-gradient(135deg, rgba(255,193,7,0.1), rgba(0,0,0,0.8)); border: 1px solid rgba(255,193,7,0.4); transform-style: preserve-3d; transition: transform 0.5s;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-warning fw-bold fs-5"><i class="bi bi-award me-2"></i>CINEMAX CLUB</span>
                            <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1 fs-6"><?= ucfirst($ml) ?></span>
                        </div>
                        <h3 class="text-light fw-bold font-monospace mb-0" style="letter-spacing: 2px;">
                            CX-<?= str_pad($user->id, 6, '0', STR_PAD_LEFT) ?>
                        </h3>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-secondary">Chi tiêu: <strong class="text-light"><?= number_format($user->total_spent ?? 0, 0, ',', '.') ?>₫</strong></small>
                                <small class="text-secondary">Mục tiêu: <?= ucfirst($nextLevel ?? 'Max') ?></small>
                            </div>
                            <div class="progress bg-dark" style="height: 6px;">
                                <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width: <?= $levelProgress ?? 0 ?>%"></div>
                            </div>
                            <small class="text-warning mt-2 d-block fst-italic">
                                Còn <?= number_format($pointsToNextLevel ?? 0, 0, ',', '.') ?>₫ để lên hạng
                            </small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="/profile/edit" class="btn btn-outline-warning rounded-pill">
                        <i class="bi bi-pencil-square me-1"></i>Chỉnh sửa hồ sơ
                    </a>
                    <a href="/profile/transactions" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-receipt me-1"></i>Lịch sử giao dịch
                    </a>
                    <a href="/profile/change-password" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-shield-lock me-1"></i>Đổi mật khẩu
                    </a>
                    <a href="/my-tickets" class="btn btn-outline-info rounded-pill">
                        <i class="bi bi-ticket-perforated me-1"></i>Vé của tôi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phải -->
    <div class="col-lg-8" data-aos="fade-left">
        <div class="card bg-dark border-0 shadow-lg mb-4 hover-shadow transition-all">
            <div class="card-header bg-black border-bottom border-secondary d-flex justify-content-between">
                <h5 class="mb-0 text-warning"><i class="bi bi-person-badge me-2"></i>Thông tin cá nhân</h5>
                <a href="/profile/edit" class="btn btn-sm btn-outline-warning rounded-pill"><i class="bi bi-pencil me-1"></i>Sửa</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Họ và tên</small>
                        <span class="text-light"><?= htmlspecialchars($user->full_name ?: 'Chưa cập nhật') ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Tên đăng nhập</small>
                        <span class="text-light"><?= htmlspecialchars($user->username) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Email</small>
                        <span class="text-light"><?= htmlspecialchars($user->email) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Số điện thoại</small>
                        <span class="text-light"><?= htmlspecialchars($user->phone ?: 'Chưa cập nhật') ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Ngày sinh</small>
                        <span class="text-light"><?= $user->date_of_birth ? date('d/m/Y', strtotime($user->date_of_birth)) : 'Chưa cập nhật' ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Giới tính</small>
                        <span class="text-light"><?= match($user->gender ?? 'other') { 'male' => 'Nam', 'female' => 'Nữ', default => 'Khác' } ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Thành phố</small>
                        <span class="text-light"><?= htmlspecialchars($user->city ?: 'Chưa cập nhật') ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Ngày tham gia</small>
                        <span class="text-light"><?= date('d/m/Y', strtotime($user->created_at)) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-dark border-0 shadow-lg hover-shadow transition-all" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header bg-black border-bottom border-secondary d-flex justify-content-between">
                <h5 class="mb-0 text-warning"><i class="bi bi-ticket-perforated me-2"></i>Vé gần đây</h5>
                <a href="/my-tickets" class="btn btn-sm btn-outline-warning rounded-pill">Xem tất cả <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentTickets)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-ticket-perforated fs-1 text-secondary opacity-50"></i>
                        <p class="text-secondary mt-2">Bạn chưa mua vé nào</p>
                        <a href="/movies" class="btn btn-warning rounded-pill"><i class="bi bi-play-circle me-1"></i>Khám phá phim</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($recentTickets as $ticket): ?>
                        <div class="ticket-item p-3 border-bottom border-secondary d-flex gap-3 align-items-center"
                             onclick="location.href='/my-tickets/<?= $ticket->id ?>'">
                            <img src="<?= htmlspecialchars($ticket->poster_url ?? '/assets/images/no-poster.jpg') ?>"
                                 class="rounded-3" width="60" height="80" style="object-fit: cover;"
                                 alt="<?= htmlspecialchars($ticket->movie_title) ?>">
                            <div class="flex-grow-1">
                                <h6 class="text-light mb-1"><?= htmlspecialchars($ticket->movie_title) ?></h6>
                                <small class="text-secondary d-block">
                                    <i class="bi bi-calendar3 me-1"></i><?= htmlspecialchars($ticket->show_date) ?>
                                    lúc <?= htmlspecialchars($ticket->start_time) ?>
                                </small>
                                <small class="text-secondary">
                                    Ghế: <span class="text-warning"><?= htmlspecialchars($ticket->seat_code) ?></span>
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge <?= $ticket->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill">
                                    <?= $ticket->status === 'paid' ? 'Đã TT' : 'Đang giữ' ?>
                                </span>
                                <div class="text-warning fw-bold mt-1"><?= number_format($ticket->total_price, 0, ',', '.') ?>₫</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="card bg-dark border-0 shadow-lg mt-4 hover-shadow transition-all" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header bg-black border-bottom border-secondary d-flex justify-content-between">
                <h5 class="mb-0 text-success"><i class="bi bi-wallet2 me-2"></i>Kho Voucher Của Tôi</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border border-success rounded-3 bg-dark position-relative">
                            <div class="position-absolute top-0 end-0 m-2 badge bg-success">MỚI</div>
                            <h6 class="text-light fw-bold mb-1">Giảm 50K Cuối Tuần</h6>
                            <p class="text-secondary small mb-2">Áp dụng cho mọi suất chiếu thứ 7, CN</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <code class="text-warning fs-5">WEEKEND50</code>
                                <button class="btn btn-sm btn-outline-success">Sử dụng</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border border-secondary rounded-3 bg-dark opacity-75">
                            <h6 class="text-light fw-bold mb-1">Tặng Bắp Nước</h6>
                            <p class="text-secondary small mb-2">Chỉ áp dụng thứ 3 Vui Vẻ</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <code class="text-secondary fs-5">POPCORNFREE</code>
                                <span class="badge bg-secondary">Hết hạn</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Thêm hiệu ứng nghiêng 3D cho thẻ Tier Card
document.addEventListener('DOMContentLoaded', () => {
    const card = document.querySelector('.tier-card-3d');
    if (card) {
        const inner = card.querySelector('.tier-card-inner');
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (centerY - y) / 10;
            const rotateY = (x - centerX) / 10;
            inner.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        card.addEventListener('mouseleave', () => {
            inner.style.transform = 'rotateX(0) rotateY(0)';
        });
    }
});
</script>
