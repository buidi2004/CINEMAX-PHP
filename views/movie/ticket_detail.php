<?php
// views/movie/ticket_detail.php
use App\Core\Session;
$ticketCode = $ticket->ticket_code ?? ('CX-' . strtoupper(substr(md5($ticket->id), 0, 8)));
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6" data-aos="fade-down" data-aos-duration="1000">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/my-tickets" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i>Về danh sách
            </a>
            <h4 class="text-warning fw-bold mb-0">Vé Chi Tiết</h4>
        </div>

        <!-- Vùng chứa vé 3D -->
        <div class="ticket-3d-container mx-auto mb-4" id="ticket-card" style="perspective: 1000px;" data-aos="zoom-in" data-aos-delay="300">
            <div class="ticket-3d-inner position-relative w-100" style="transition: transform 0.8s; transform-style: preserve-3d; cursor: pointer;">
                <!-- MẶT TRƯỚC -->
                <div class="ticket-3d-front">
                    <div class="ticket-front-content">
                        <div class="ticket-top d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="text-warning fw-bold mb-0"><i class="bi bi-camera-reels me-1"></i>CinemaX</h4>
                                <small class="text-secondary">Electronic Ticket</small>
                            </div>
                            <span class="badge <?= $ticket->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i><?= $ticket->status === 'paid' ? 'Đã thanh toán' : 'Đang giữ' ?>
                            </span>
                        </div>

                        <div class="ticket-tear-line my-3"></div>

                        <div class="mb-3">
                            <h3 class="text-light fw-bold mb-1"><?= htmlspecialchars($ticket->movie_title) ?></h3>
                            <span class="badge bg-danger me-1"><?= htmlspecialchars($ticket->age_rating ?? 'P') ?></span>
                            <span class="text-secondary"><?= htmlspecialchars($ticket->duration_minutes ?? '') ?> phút</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="ticket-info-block">
                                    <i class="bi bi-calendar3 text-warning"></i>
                                    <small class="text-secondary d-block">Ngày chiếu</small>
                                    <strong class="text-light"><?= htmlspecialchars($ticket->show_date) ?></strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ticket-info-block">
                                    <i class="bi bi-clock text-warning"></i>
                                    <small class="text-secondary d-block">Giờ chiếu</small>
                                    <strong class="text-light fs-5"><?= htmlspecialchars($ticket->start_time) ?></strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ticket-info-block">
                                    <i class="bi bi-geo-alt text-danger"></i>
                                    <small class="text-secondary d-block">Rạp</small>
                                    <strong class="text-light"><?= htmlspecialchars($ticket->cinema_name ?? 'CinemaX') ?></strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ticket-info-block">
                                    <i class="bi bi-door-open text-info"></i>
                                    <small class="text-secondary d-block">Phòng chiếu</small>
                                    <strong class="text-light"><?= htmlspecialchars($ticket->room_name) ?></strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ticket-info-block">
                                    <i class="bi bi-grid-3x3-gap text-success"></i>
                                    <small class="text-secondary d-block">Ghế</small>
                                    <strong class="text-warning fs-4"><?= htmlspecialchars($ticket->seat_code) ?></strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ticket-info-block">
                                    <i class="bi bi-cash-coin text-warning"></i>
                                    <small class="text-secondary d-block">Giá vé</small>
                                    <strong class="text-warning fs-5"><?= number_format($ticket->total_price, 0, ',', '.') ?>₫</strong>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <small class="text-secondary flip-hint"><i class="bi bi-arrow-repeat me-1"></i>Click để xem mã QR</small>
                        </div>
                    </div>
                </div>

                <!-- MẶT SAU — MÃ QR -->
                <div class="ticket-3d-back">
                    <div class="ticket-back-content text-center py-4">
                        <h5 class="text-warning fw-bold mb-3"><i class="bi bi-qr-code me-2"></i>MÃ VÉ ĐIỆN TỬ</h5>

                        <div class="qr-container bg-white p-4 rounded-4 d-inline-block mx-auto mb-3">
                            <div id="qr-code" data-ticket-code="<?= htmlspecialchars($ticketCode) ?>"></div>
                        </div>

                        <div class="ticket-code-display mb-3">
                            <span class="font-monospace text-warning fs-4 fw-bold letter-spacing-2"><?= htmlspecialchars($ticketCode) ?></span>
                        </div>

                        <p class="text-secondary small mb-2">Đưa mã QR này cho nhân viên soát vé</p>
                        <p class="text-secondary small"><i class="bi bi-info-circle me-1"></i>Mã vé có hiệu lực đến <?= htmlspecialchars($ticket->show_date) ?></p>

                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <button class="btn btn-outline-warning rounded-pill btn-sm" onclick="shareTicket()">
                                <i class="bi bi-share me-1"></i>Chia sẻ
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-secondary flip-hint"><i class="bi bi-arrow-repeat me-1"></i>Click để xem thông tin vé</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin bổ sung -->
        <div class="card bg-dark border-0 shadow-lg">
            <div class="card-header bg-black border-bottom border-secondary">
                <h5 class="mb-0 text-warning"><i class="bi bi-info-circle me-2"></i>Thông tin đặt vé</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Mã vé</small>
                        <span class="text-light font-monospace"><?= htmlspecialchars($ticketCode) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Thời gian đặt</small>
                        <span class="text-light"><?= date('d/m/Y H:i', strtotime($ticket->booked_at)) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Trạng thái</small>
                        <span class="badge <?= $ticket->status === 'paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
                            <?= $ticket->status === 'paid' ? 'Đã thanh toán' : ucfirst($ticket->status) ?>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-block">Giá vé</small>
                        <span class="text-warning fw-bold"><?= number_format($ticket->total_price, 0, ',', '.') ?>₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Library -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const qrContainer = document.getElementById('qr-code');
    if (qrContainer) {
        const ticketCode = qrContainer.dataset.ticketCode;
        new QRCode(qrContainer, {
            text: 'CINEMAX-TICKET:' + ticketCode,
            width: 180, height: 180,
            colorDark: '#000000', colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    const ticketCard = document.getElementById('ticket-card');
    if (ticketCard) {
        ticketCard.addEventListener('click', () => { ticketCard.classList.toggle('flipped'); });
    }
});

function shareTicket() {
    if (navigator.share) {
        navigator.share({ title: 'Vé xem phim CinemaX', text: 'Xem chi tiết vé!', url: window.location.href });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Đã copy link vé!');
    }
}
</script>
