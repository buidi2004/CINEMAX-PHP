<?php

namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IPaymentService;
use App\Models\Services\Payment\IPaymentStrategy;
use App\Models\Services\Payment\VNPayStrategy;
use App\Models\Services\Payment\MoMoStrategy;
use App\Models\Services\Payment\CashStrategy;
use App\Core\ValueObjects\PaymentRequest;
use App\Core\ValueObjects\PaymentResult;

class PaymentService implements IPaymentService
{
    private array $strategies = [];

    public function __construct()
    {
        // Register payment strategies
        $this->registerStrategy(new VNPayStrategy());
        $this->registerStrategy(new MoMoStrategy());
        $this->registerStrategy(new CashStrategy());
    }

    private function registerStrategy(IPaymentStrategy $strategy): void
    {
        $this->strategies[$strategy->getMethodName()] = $strategy;
    }

    private function getStrategy(string $method): IPaymentStrategy
    {
        if (!isset($this->strategies[$method])) {
            throw new \InvalidArgumentException("Payment method not supported: {$method}");
        }

        return $this->strategies[$method];
    }

    public function process(string $method, PaymentRequest $request): PaymentResult
    {
        $strategy = $this->getStrategy($method);
        return $strategy->processPayment($request);
    }

    public function verifyCallback(string $method, array $data): PaymentResult
    {
        $strategy = $this->getStrategy($method);
        return $strategy->verifyCallback($data);
    }

    public function getPaymentUrl(PaymentRequest $request): string
    {
        $strategy = $this->getStrategy($request->getPaymentMethod());
        return $strategy->createPaymentUrl($request);
    }

    public function refundPayment(int $ticketId, float $amount, string $reason): bool
    {
        // Determine payment method from ticket
        // For now, we'll need to get this from ticket record
        // TODO: Add method to get payment method from ticket
        
        return false;
    }
}
