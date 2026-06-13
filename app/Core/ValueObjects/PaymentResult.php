<?php
namespace App\Core\ValueObjects;

class PaymentResult
{
    public function __construct(
        public readonly bool   $success,
        public readonly string $transactionId,
        public readonly string $message = '',
        public readonly ?string $paymentMethod = null,
        public readonly ?string $redirectUrl = null,
        public readonly ?float  $amount = null,
        public readonly ?string $gatewayTransactionId = null
    ) {}
}
