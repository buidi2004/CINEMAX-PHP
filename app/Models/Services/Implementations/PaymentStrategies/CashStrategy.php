<?php
namespace App\Models\Services\Implementations\PaymentStrategies;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

class CashStrategy implements IPaymentStrategy
{
    public function process(PaymentRequest $request): PaymentResult
    {
        // Thanh toán tại quầy - tạo transaction ID đơn giản
        $transactionId = 'CASH_' . time() . '_' . $request->userId;
        
        return new PaymentResult(
            success: true,
            transactionId: $transactionId,
            message: 'Vui lòng thanh toán tại quầy khi nhận vé. Mã giao dịch: ' . $transactionId
        );
    }
    
    public function verifyCallback(array $data): PaymentResult
    {
        // Cash payment không có callback
        return new PaymentResult(
            success: true,
            transactionId: $data['txn_id'] ?? '',
            message: 'Cash payment verified'
        );
    }
}
