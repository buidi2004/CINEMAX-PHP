<?php

namespace App\Models\Services\Payment;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

class VNPayStrategy implements IPaymentStrategy
{
    private string $vnpUrl;
    private string $vnpTmnCode;
    private string $vnpHashSecret;
    private string $vnpReturnUrl;

    public function __construct()
    {
        // Load from environment
        $this->vnpUrl = $_ENV['VNPAY_URL'] ?? 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $this->vnpTmnCode = $_ENV['VNPAY_TMN_CODE'] ?? 'DEMO_TMN_CODE';
        $this->vnpHashSecret = $_ENV['VNPAY_HASH_SECRET'] ?? 'DEMO_HASH_SECRET';
        $this->vnpReturnUrl = $_ENV['VNPAY_RETURN_URL'] ?? 'http://localhost:8000/payment/vnpay-callback';
    }

    public function getMethodName(): string
    {
        return 'vnpay';
    }

    public function createPaymentUrl(PaymentRequest $request): string
    {
        $vnpData = [
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'pay',
            'vnp_TmnCode' => $this->vnpTmnCode,
            'vnp_Amount' => $request->getAmount() * 100, // VNPay uses smallest currency unit
            'vnp_CurrCode' => 'VND',
            'vnp_TxnRef' => $request->getTransactionId(),
            'vnp_OrderInfo' => $request->getDescription(),
            'vnp_OrderType' => 'billpayment',
            'vnp_Locale' => 'vn',
            'vnp_ReturnUrl' => $this->vnpReturnUrl,
            'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'vnp_CreateDate' => date('YmdHis'),
        ];

        // Sort data by key
        ksort($vnpData);

        // Build query string
        $query = http_build_query($vnpData);

        // Create secure hash
        $secureHash = hash_hmac('sha512', $query, $this->vnpHashSecret);

        // Final URL
        return $this->vnpUrl . '?' . $query . '&vnp_SecureHash=' . $secureHash;
    }

    public function processPayment(PaymentRequest $request): PaymentResult
    {
        // VNPay requires redirect to payment page
        return new PaymentResult(
            success: false,
            transactionId: $request->getTransactionId(),
            message: 'Redirect to VNPay required',
            paymentMethod: 'vnpay',
            redirectUrl: $this->createPaymentUrl($request)
        );
    }

    public function verifyCallback(array $data): PaymentResult
    {
        // Extract secure hash from callback
        $vnpSecureHash = $data['vnp_SecureHash'] ?? '';
        unset($data['vnp_SecureHash']);
        unset($data['vnp_SecureHashType']);

        // Sort data
        ksort($data);

        // Build query string
        $query = http_build_query($data);

        // Calculate secure hash
        $calculatedHash = hash_hmac('sha512', $query, $this->vnpHashSecret);

        // Verify signature
        if ($vnpSecureHash !== $calculatedHash) {
            return new PaymentResult(
                success: false,
                transactionId: $data['vnp_TxnRef'] ?? '',
                message: 'Invalid signature',
                paymentMethod: 'vnpay'
            );
        }

        // Check response code
        $responseCode = $data['vnp_ResponseCode'] ?? '';
        $success = ($responseCode === '00');

        return new PaymentResult(
            success: $success,
            transactionId: $data['vnp_TxnRef'] ?? '',
            message: $success ? 'Payment successful' : 'Payment failed: ' . $responseCode,
            paymentMethod: 'vnpay',
            amount: isset($data['vnp_Amount']) ? (float)$data['vnp_Amount'] / 100 : 0,
            gatewayTransactionId: $data['vnp_TransactionNo'] ?? null
        );
    }

    public function refund(int $ticketId, float $amount, string $reason): bool
    {
        // VNPay refund API call
        // TODO: Implement refund API
        return false;
    }
}
