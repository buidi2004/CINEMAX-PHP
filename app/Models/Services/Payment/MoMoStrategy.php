<?php

namespace App\Models\Services\Payment;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

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
        // Load from environment
        $this->partnerCode = $_ENV['MOMO_PARTNER_CODE'] ?? 'DEMO_PARTNER';
        $this->accessKey = $_ENV['MOMO_ACCESS_KEY'] ?? 'DEMO_ACCESS';
        $this->secretKey = $_ENV['MOMO_SECRET_KEY'] ?? 'DEMO_SECRET';
        $this->endpoint = $_ENV['MOMO_ENDPOINT'] ?? 'https://test-payment.momo.vn/v2/gateway/api/create';
        $this->returnUrl = $_ENV['MOMO_RETURN_URL'] ?? 'http://localhost:8000/payment/momo-callback';
        $this->notifyUrl = $_ENV['MOMO_NOTIFY_URL'] ?? 'http://localhost:8000/payment/momo-ipn';
    }

    public function getMethodName(): string
    {
        return 'momo';
    }

    public function createPaymentUrl(PaymentRequest $request): string
    {
        $orderId = $request->getTransactionId();
        $amount = (int)$request->getAmount();
        $orderInfo = $request->getDescription();
        $requestId = $orderId . '_' . time();
        $requestType = 'captureWallet';
        $extraData = '';

        // Create signature
        $rawHash = "accessKey={$this->accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$this->notifyUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$this->partnerCode}&redirectUrl={$this->returnUrl}&requestId={$requestId}&requestType={$requestType}";
        
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $this->returnUrl,
            'ipnUrl' => $this->notifyUrl,
            'requestType' => $requestType,
            'extraData' => $extraData,
            'lang' => 'vi',
            'signature' => $signature
        ];

        // Call MoMo API
        $result = $this->callMoMoAPI($data);

        return $result['payUrl'] ?? '';
    }

    public function processPayment(PaymentRequest $request): PaymentResult
    {
        // MoMo requires redirect to payment page
        $paymentUrl = $this->createPaymentUrl($request);

        return new PaymentResult(
            success: false,
            transactionId: $request->getTransactionId(),
            message: 'Redirect to MoMo required',
            paymentMethod: 'momo',
            redirectUrl: $paymentUrl
        );
    }

    public function verifyCallback(array $data): PaymentResult
    {
        // Verify signature
        $signature = $data['signature'] ?? '';
        
        $rawHash = "accessKey={$this->accessKey}&amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";
        
        $calculatedSignature = hash_hmac('sha256', $rawHash, $this->secretKey);

        if ($signature !== $calculatedSignature) {
            return new PaymentResult(
                success: false,
                transactionId: $data['orderId'] ?? '',
                message: 'Invalid signature',
                paymentMethod: 'momo'
            );
        }

        // Check result code
        $resultCode = $data['resultCode'] ?? -1;
        $success = ($resultCode == 0);

        return new PaymentResult(
            success: $success,
            transactionId: $data['orderId'] ?? '',
            message: $success ? 'Payment successful' : ($data['message'] ?? 'Payment failed'),
            paymentMethod: 'momo',
            amount: isset($data['amount']) ? (float)$data['amount'] : 0,
            gatewayTransactionId: $data['transId'] ?? null
        );
    }

    public function refund(int $ticketId, float $amount, string $reason): bool
    {
        // MoMo refund API
        // TODO: Implement refund API
        return false;
    }

    private function callMoMoAPI(array $data): array
    {
        $ch = curl_init($this->endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true) ?? [];
    }
}
