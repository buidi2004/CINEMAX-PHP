<?php
namespace App\Models\Services\Implementations\PaymentStrategies;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;
use App\Core\Exceptions\BusinessException;

class VNPayStrategy implements IPaymentStrategy
{
    private string $vnpTmnCode;
    private string $vnpHashSecret;
    private string $vnpUrl;
    private string $vnpReturnUrl;
    
    public function __construct()
    {
        $this->vnpTmnCode = $_ENV['VNPAY_TMN_CODE'] ?? 'DEMO';
        $this->vnpHashSecret = $_ENV['VNPAY_HASH_SECRET'] ?? 'DEMO_SECRET';
        $this->vnpUrl = $_ENV['VNPAY_URL'] ?? 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $this->vnpReturnUrl = $_ENV['VNPAY_RETURN_URL'] ?? 'http://localhost:8000/payment/vnpay-callback';
    }
    
    public function process(PaymentRequest $request): PaymentResult
    {
        $orderId = time() . '_' . $request->userId;
        
        $vnpData = [
            'vnp_Version' => '2.1.0',
            'vnp_Command' => 'pay',
            'vnp_TmnCode' => $this->vnpTmnCode,
            'vnp_Amount' => $request->amount * 100, // VNPay requires amount in cents
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => $request->orderDescription,
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => $this->vnpReturnUrl,
            'vnp_TxnRef' => $orderId,
        ];
        
        // Sort by key
        ksort($vnpData);
        
        // Generate hash
        $hashData = http_build_query($vnpData);
        $vnpSecureHash = hash_hmac('sha512', $hashData, $this->vnpHashSecret);
        $vnpData['vnp_SecureHash'] = $vnpSecureHash;
        
        // Generate payment URL
        $paymentUrl = $this->vnpUrl . '?' . http_build_query($vnpData);
        
        return new PaymentResult(
            success: true,
            transactionId: $orderId,
            message: 'redirect:' . $paymentUrl
        );
    }
    
    public function verifyCallback(array $data): PaymentResult
    {
        $vnpSecureHash = $data['vnp_SecureHash'] ?? '';
        unset($data['vnp_SecureHash']);
        
        ksort($data);
        $hashData = http_build_query($data);
        $secureHashCheck = hash_hmac('sha512', $hashData, $this->vnpHashSecret);
        
        if ($vnpSecureHash !== $secureHashCheck) {
            throw new BusinessException('Invalid VNPay signature');
        }
        
        $responseCode = $data['vnp_ResponseCode'] ?? '';
        $transactionId = $data['vnp_TxnRef'] ?? '';
        
        if ($responseCode === '00') {
            return new PaymentResult(
                success: true,
                transactionId: $transactionId,
                message: 'Payment successful'
            );
        }
        
        return new PaymentResult(
            success: false,
            transactionId: $transactionId,
            message: 'Payment failed: ' . $this->getResponseMessage($responseCode)
        );
    }
    
    private function getResponseMessage(string $code): string
    {
        $messages = [
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
            '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Giao dịch không thành công do: Đã hết hạn chờ thanh toán.',
            '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
            '13' => 'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP).',
            '24' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch',
            '51' => 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
            '65' => 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
            '75' => 'Ngân hàng thanh toán đang bảo trì.',
            '79' => 'Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định.',
            '99' => 'Các lỗi khác (lỗi còn lại, không có trong danh sách mã lỗi đã liệt kê)',
        ];
        
        return $messages[$code] ?? 'Lỗi không xác định';
    }
}
