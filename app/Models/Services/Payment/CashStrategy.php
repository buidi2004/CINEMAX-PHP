<?php

namespace App\Models\Services\Payment;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

class CashStrategy implements IPaymentStrategy
{
    public function getMethodName(): string
    {
        return 'cash';
    }

    public function createPaymentUrl(PaymentRequest $request): string
    {
        // Cash payment doesn't need redirect
        return '';
    }

    public function processPayment(PaymentRequest $request): PaymentResult
    {
        // Cash payment is always "successful" at booking time
        // Actual payment happens at cinema counter
        return new PaymentResult(
            success: true,
            transactionId: $request->getTransactionId(),
            message: 'Đặt vé thành công. Vui lòng thanh toán tại quầy trước 15 phút chiếu phim.',
            paymentMethod: 'cash',
            amount: $request->getAmount()
        );
    }

    public function verifyCallback(array $data): PaymentResult
    {
        // Cash payment doesn't have callbacks
        return new PaymentResult(
            success: false,
            transactionId: '',
            message: 'Cash payment does not support callbacks',
            paymentMethod: 'cash'
        );
    }

    public function refund(int $ticketId, float $amount, string $reason): bool
    {
        // Cash refund is handled manually at cinema
        return true;
    }
}
