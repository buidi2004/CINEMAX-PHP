<?php
namespace App\Models\Services\Implementations\PaymentStrategies;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;
use App\Core\Exceptions\BusinessException;

class MoMoStrategy implements IPaymentStrategy
{
    private string $partnerCode;
    private string $accessKey;
    private string $secretKey;
    private string $endpoint;
    private string $returnUrl;
    private string $notifyUrl;
    
    public function __construct()
    {
        $this->partnerCode = $_ENV['MOMO_PARTNER_CODE'] ?? 'DEMO';
        $this->accessKey = $_ENV['MOMO_ACCESS_KEY'] ?? 'DEMO_ACCESS';
        $this->secretKey = $_ENV['MOMO_SECRET_KEY'] ?? 'DEMO_SECRET';
        $this->endpoint = $_ENV['MOMO_ENDPOINT'] ?? 'https://test-payment.momo.vn/v2/gateway/api/create';
        $this->returnUrl = $_ENV['MOMO_RETURN_URL'] ?? 'http://localhost:8000/payment/momo-callback';
        $this->notifyUrl = $_ENV['MOMO_NOTIFY_URL'] ?? 'http://localhost:8000/payment/momo-ipn';
    }
    
    public function process(PaymentRequest $request): PaymentResult
    {
        $orderId = time() . '_' . $request->userId;
        $requestId = $orderId . '_' . uniqid();
        
        $requestData = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => 'CinemaX',
            'storeId' => 'CinemaXStore',
            'requestId' => $requestId,
            'amount' => (string) $request->amount,
            'orderId' => $orderId,
            'orderInfo' => $request->orderDescription,
            'redirectUrl' => $this->returnUrl,
            'ipnUrl' => $this->notifyUrl,
            'lang' => 'vi',
            'extraData' => base64_encode(json_encode(['userId' => $request->userId])),
            'requestType' => 'captureWallet',
            'autoCapture' => true,
        ];
        
        // Generate signature
        $rawSignature = "accessKey=" . $this->accessKey 
            . "&amount=" . $requestData['amount']
            . "&extraData=" . $requestData['extraData']
            . "&ipnUrl=" . $requestData['ipnUrl']
            . "&orderId=" . $requestData['orderId']
            . "&orderInfo=" . $requestData['orderInfo']
            . "&partnerCode=" . $requestData['partnerCode']
            . "&redirectUrl=" . $requestData['redirectUrl']
            . "&requestId=" . $requestData['requestId']
            . "&requestType=" . $requestData['requestType'];
        
        $requestData['signature'] = hash_hmac('sha256', $rawSignature, $this->secretKey);
        
        // Make API request
        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($requestData))
            ],
            CURLOPT_TIMEOUT => 30,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new BusinessException('MoMo API error: HTTP ' . $httpCode);
        }
        
        $result = json_decode($response, true);
        
        if (isset($result['resultCode']) && $result['resultCode'] == 0) {
            return new PaymentResult(
                success: true,
                transactionId: $orderId,
                message: 'redirect:' . $result['payUrl']
            );
        }
        
        throw new BusinessException('MoMo error: ' . ($result['message'] ?? 'Unknown error'));
    }
    
    public function verifyCallback(array $data): PaymentResult
    {
        $signature = $data['signature'] ?? '';
        
        // Verify signature
        $rawSignature = "accessKey=" . $this->accessKey
            . "&amount=" . ($data['amount'] ?? '')
            . "&extraData=" . ($data['extraData'] ?? '')
            . "&message=" . ($data['message'] ?? '')
            . "&orderId=" . ($data['orderId'] ?? '')
            . "&orderInfo=" . ($data['orderInfo'] ?? '')
            . "&orderType=" . ($data['orderType'] ?? '')
            . "&partnerCode=" . ($data['partnerCode'] ?? '')
            . "&payType=" . ($data['payType'] ?? '')
            . "&requestId=" . ($data['requestId'] ?? '')
            . "&responseTime=" . ($data['responseTime'] ?? '')
            . "&resultCode=" . ($data['resultCode'] ?? '')
            . "&transId=" . ($data['transId'] ?? '');
        
        $checkSignature = hash_hmac('sha256', $rawSignature, $this->secretKey);
        
        if ($signature !== $checkSignature) {
            throw new BusinessException('Invalid MoMo signature');
        }
        
        $resultCode = $data['resultCode'] ?? -1;
        $transactionId = $data['orderId'] ?? '';
        
        if ($resultCode == 0) {
            return new PaymentResult(
                success: true,
                transactionId: $transactionId,
                message: 'Payment successful'
            );
        }
        
        return new PaymentResult(
            success: false,
            transactionId: $transactionId,
            message: 'Payment failed: ' . ($data['message'] ?? 'Unknown error')
        );
    }
}
