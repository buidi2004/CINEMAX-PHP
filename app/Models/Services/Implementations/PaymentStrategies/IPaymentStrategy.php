<?php
namespace App\Models\Services\Implementations\PaymentStrategies;

use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

interface IPaymentStrategy
{
    public function process(PaymentRequest $request): PaymentResult;
    public function verifyCallback(array $data): PaymentResult;
}
