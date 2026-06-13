<?php
namespace App\Core\ValueObjects;

class PaymentRequest
{
    public readonly string $transactionId;

    public function __construct(
        public readonly float  $amount,
        public readonly string $orderDescription,
        public readonly array  $ticketIds,
        public readonly int    $userId,
        ?string $transactionId = null
    ) {
        $this->transactionId = $transactionId ?? uniqid('txn_') . '_' . $userId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->orderDescription;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}
