<?php

namespace App\Models\Services\Payment;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

interface IPaymentStrategy
{
    /**
     * Get payment method name
     */
    public function getMethodName(): string;

    /**
     * Create payment URL for redirect
     */
    public function createPaymentUrl(PaymentRequest $request): string;

    /**
     * Process payment (for direct payment methods like cash)
     */
    public function processPayment(PaymentRequest $request): PaymentResult;

    /**
     * Verify payment callback from gateway
     */
    public function verifyCallback(array $data): PaymentResult;

    /**
     * Refund payment
     */
    public function refund(int $ticketId, float $amount, string $reason): bool;
}
