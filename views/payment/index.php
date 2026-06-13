<?php
// views/payment/index.php
$remainingSeconds = max(0, strtotime($booking->holdExpiryTime) - time());
?>
<div class="row justify-content-center">
    <div class="col-lg-7">

        <!-- Countdown Timer -->
        <div class="alert alert-warning border-0 shadow-lg d-flex align-items-center mb-4 p-3" role="alert" style="background-color: #382c0f; color: #ffc107;">
            <i class="bi bi-clock-history me-3 fs-3 animate-pulse"></i>
            <div class="timer-container ms-auto">
                <span class="d-block small text-secondary me-2">Thời gian giữ ghế:</span>
                <strong id="countdown-timer" class="timer-value" data-remaining-seconds="<?= $remainingSeconds ?>">--:--</strong>
            </div>
        </div>

        <!-- Thông tin đặt vé -->
        <div class="card bg-secondary border-0 shadow mb-4" style="background-color: #1a1a2e !important; border: 1px solid #2d2d44 !important;">
            <div class="card-header bg-black py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-film me-2 text-warning"></i>Chi tiết đặt vé</h5>
            </div>
            <div class="card-body p-4">
                <h4 class="text-warning fw-bold mb-3"><?= htmlspecialchars($booking->movieTitle) ?></h4>
                <div class="row g-2 mb-3">
                    <div class="col-sm-6 text-secondary">
                        <i class="bi bi-calendar3 me-2 text-light"></i>Ngày chiếu: <span class="text-light fw-semibold"><?= date('d/m/Y', strtotime($booking->showDate)) ?></span>
                    </div>
                    <div class="col-sm-6 text-secondary">
                        <i class="bi bi-clock me-2 text-light"></i>Suất chiếu: <span class="text-light fw-semibold"><?= date('H:i', strtotime($booking->startTime)) ?></span>
                    </div>
                    <div class="col-sm-6 text-secondary">
                        <i class="bi bi-door-open me-2 text-light"></i>Phòng chiếu: <span class="text-light fw-semibold"><?= htmlspecialchars($booking->roomName) ?></span>
                    </div>
                    <div class="col-sm-6 text-secondary">
                        <i class="bi bi-ticket me-2 text-light"></i>Số lượng: <span class="text-light fw-semibold"><?= $booking->quantity ?> vé</span>
                    </div>
                </div>
                <hr class="border-secondary">
                <div class="mb-0">
                    <label class="text-secondary small fw-bold d-block mb-2">Ghế ngồi đã chọn:</label>
                    <?php foreach ($booking->selectedSeats as $seat): ?>
                        <span class="badge bg-success fs-6 me-2 shadow-sm"><?= htmlspecialchars($seat) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Mã giảm giá -->
        <div class="card bg-secondary border-0 shadow mb-4" style="background-color: #1a1a2e !important; border: 1px solid #2d2d44 !important;">
            <div class="card-body p-4">
                <label class="form-label text-light fw-bold">Mã giảm giá (Voucher)</label>
                <div class="input-group">
                    <input type="text" id="promo-input"
                           class="form-control bg-dark text-light border-secondary py-2"
                           placeholder="Nhập mã giảm giá (ví dụ: GIAM20)..."
                           value="<?= htmlspecialchars($booking->promotionCode ?? '') ?>">
                    <button class="btn btn-warning fw-bold px-4" id="btn-apply-promo" type="button">
                        Áp dụng
                    </button>
                </div>
                <div id="promo-feedback" class="mt-2 small"></div>
            </div>
        </div>
        <!-- Dịch vụ Bắp nước -->
        <?php if (!empty($food_beverages)): ?>
        <div class="card bg-secondary border-0 shadow mb-4" style="background-color: #1a1a2e !important; border: 1px solid #2d2d44 !important;">
            <div class="card-header bg-black py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-cup-straw me-2 text-warning"></i>Bắp nước (Tùy chọn)</h5>
            </div>
            <div class="card-body p-4">
                <?php foreach ($food_beverages as $fb): ?>
                    <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-3 mb-3 fb-item" data-id="<?= $fb['id'] ?>" data-price="<?= $fb['price'] ?>" data-name="<?= htmlspecialchars($fb['name']) ?>">
                        <div class="d-flex align-items-center">
                            <?php if ($fb['image_url']): ?>
                                <img src="<?= htmlspecialchars($fb['image_url']) ?>" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                            <?php else: ?>
                                <div class="bg-dark rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="bi bi-cup text-secondary"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h6 class="text-light mb-1"><?= htmlspecialchars($fb['name']) ?></h6>
                                <span class="text-warning fw-bold"><?= number_format($fb['price'], 0, ',', '.') ?>₫</span>
                            </div>
                        </div>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary btn-sm fb-minus" type="button"><i class="bi bi-dash"></i></button>
                            <input type="text" class="form-control text-center bg-dark text-light border-secondary p-0 fb-qty" value="0" readonly>
                            <button class="btn btn-outline-warning btn-sm fb-plus" type="button"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- Tổng tiền -->
        <div class="card bg-secondary border-0 shadow mb-4" style="background-color: #1a1a2e !important; border: 1px solid #2d2d44 !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Tạm tính (<span id="ticket-qty"><?= $booking->quantity ?></span> vé):</span>
                    <span class="fw-semibold text-light" id="ticket-subtotal-display" data-subtotal="<?= $booking->subtotal ?>"><?= number_format($booking->subtotal, 0, ',', '.') ?>₫</span>
                </div>
                <div class="d-flex justify-content-between mb-2" id="food-row" style="display:none!important">
                    <span class="text-secondary">Combo Bắp nước:</span>
                    <span class="fw-semibold text-light" id="food-display">+0₫</span>
                </div>
                <div class="d-flex justify-content-between mb-2" id="discount-row"
                     style="<?= $booking->discount > 0 ? '' : 'display:none!important' ?>">
                    <span class="text-success">Giảm giá:</span>
                    <span class="text-success fw-bold" id="discount-display">
                        -<?= number_format($booking->discount, 0, ',', '.') ?>₫
                    </span>
                </div>
                <hr class="border-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="text-light fs-5">TỔNG THANH TOÁN:</strong>
                    <strong class="text-warning fs-3" id="total-display">
                        <?= number_format($booking->totalPrice, 0, ',', '.') ?>₫
                    </strong>
                </div>
            </div>
        </div>

        <!-- Form thanh toán — PHẢI có CSRF token -->
        <form method="POST" action="/payment/confirm" id="payment-form">
            <?= csrf_field() ?>
            <input type="hidden" name="base_total" id="base-total" value="<?= $booking->totalPrice ?>">
            <input type="hidden" name="total_price" id="final-total" value="<?= $booking->totalPrice ?>">
            <input type="hidden" name="promotion_code" id="final-promo" value="<?= htmlspecialchars($booking->promotionCode ?? '') ?>">
            <input type="hidden" name="food_items" id="final-food-items" value="[]">
            <input type="hidden" name="food_price" id="final-food-price" value="0">

            <div class="mb-4">
                <label class="form-label fw-bold text-light mb-3">Phương thức thanh toán</label>
                <div class="d-grid gap-3">
                    <div class="form-check bg-black rounded p-3 border border-secondary shadow-sm hover-border-warning">
                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method"
                               id="pay-vnpay" value="vnpay" required>
                        <label class="form-check-label text-light w-100" for="pay-vnpay" style="cursor: pointer;">
                            <i class="bi bi-credit-card me-2 text-primary fs-5"></i>
                            <strong class="fs-6">VNPay</strong>
                            <small class="text-secondary d-block mt-1">Thẻ ATM nội địa, Internet Banking, Quét mã QR</small>
                        </label>
                    </div>
                    
                    <div class="form-check bg-black rounded p-3 border border-secondary shadow-sm hover-border-warning">
                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method"
                               id="pay-momo" value="momo">
                        <label class="form-check-label text-light w-100" for="pay-momo" style="cursor: pointer;">
                            <i class="bi bi-phone me-2 text-danger fs-5"></i>
                            <strong class="fs-6">Ví điện tử MoMo</strong>
                            <small class="text-secondary d-block mt-1">Thanh toán nhanh qua ứng dụng MoMo</small>
                        </label>
                    </div>

                    <div class="form-check bg-black rounded p-3 border border-secondary shadow-sm hover-border-warning">
                        <input class="form-check-input ms-0 me-3" type="radio" name="payment_method"
                               id="pay-cash" value="cash">
                        <label class="form-check-label text-light w-100" for="pay-cash" style="cursor: pointer;">
                            <i class="bi bi-cash-coin me-2 text-success fs-5"></i>
                            <strong class="fs-6">Thanh toán tại quầy</strong>
                            <small class="text-secondary d-block mt-1">Hoàn thành giao dịch trực tiếp tại rạp</small>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-warning w-100 btn-lg fw-bold py-3 shadow mb-4" id="btn-pay-submit">
                <i class="bi bi-check-circle me-2"></i>XÁC NHẬN THANH TOÁN
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // F&B Logic
    const fbItems = document.querySelectorAll('.fb-item');
    const foodRow = document.getElementById('food-row');
    const foodDisplay = document.getElementById('food-display');
    const baseTotalInput = document.getElementById('base-total');
    const finalTotalInput = document.getElementById('final-total');
    const totalDisplay = document.getElementById('total-display');
    const finalFoodItemsInput = document.getElementById('final-food-items');
    const finalFoodPriceInput = document.getElementById('final-food-price');

    function updateCart() {
        let foodTotal = 0;
        let cart = [];
        
        fbItems.forEach(item => {
            const qty = parseInt(item.querySelector('.fb-qty').value);
            if (qty > 0) {
                const price = parseFloat(item.dataset.price);
                foodTotal += qty * price;
                cart.push({
                    id: item.dataset.id,
                    name: item.dataset.name,
                    qty: qty,
                    price: price
                });
            }
        });

        // Update display
        if (foodTotal > 0) {
            foodRow.style.setProperty('display', 'flex', 'important');
            foodDisplay.textContent = '+' + new Intl.NumberFormat('vi-VN').format(foodTotal) + '₫';
        } else {
            foodRow.style.setProperty('display', 'none', 'important');
        }

        // Update inputs
        finalFoodItemsInput.value = JSON.stringify(cart);
        finalFoodPriceInput.value = foodTotal;

        // Update Total
        const baseTotal = parseFloat(baseTotalInput.value);
        const newTotal = baseTotal + foodTotal;
        finalTotalInput.value = newTotal;
        totalDisplay.textContent = new Intl.NumberFormat('vi-VN').format(newTotal) + '₫';
    }

    fbItems.forEach(item => {
        const minusBtn = item.querySelector('.fb-minus');
        const plusBtn = item.querySelector('.fb-plus');
        const qtyInput = item.querySelector('.fb-qty');

        minusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (val > 0) {
                qtyInput.value = val - 1;
                updateCart();
            }
        });

        plusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (val < 10) {
                qtyInput.value = val + 1;
                updateCart();
            }
        });
    });

    // Show spinner on payment form submit
    const paymentForm = document.getElementById('payment-form');
    if (paymentForm) {
        paymentForm.addEventListener('submit', () => {
            const btnSubmit = document.getElementById('btn-pay-submit');
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý giao dịch...';
            }
        });
    }
});
</script>
