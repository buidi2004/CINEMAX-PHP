<?php

namespace App\Models\Services\Interfaces;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

interface IPaymentService
{
    /**
     * Process payment using specified payment method
     * 
     * @param string $method
     * @param PaymentRequest $request
     * @return PaymentResult
     */
    public function process(string $method, PaymentRequest $request): PaymentResult;

    /**
     * Verify payment callback from payment gateway
     * 
     * @param string $method Payment method (vnpay, momo, cash)
     * @param array $data Callback data
     * @return PaymentResult
     */
    public function verifyCallback(string $method, array $data): PaymentResult;

    /**
     * Get payment URL for redirect
     * 
     * @param PaymentRequest $request
     * @return string Payment gateway URL
     */
    public function getPaymentUrl(PaymentRequest $request): string;

    /**
     * Refund payment
     * 
     * @param int $ticketId
     * @param float $amount
     * @param string $reason
     * @return bool
     */
    public function refundPayment(int $ticketId, float $amount, string $reason): bool;
}
