<?php
namespace App\Models\Domain;

class Ticket extends BaseModel
{
    public int     $id;
    public int     $showtimeId;
    public int     $userId;
    public string  $seatCode;
    public string  $status;           // 'holding' | 'paid' | 'cancelled'
    public ?string $holdExpiryTime = null;   // NULL khi paid/cancelled
    public float   $totalPrice;
    public ?string $promotionCode = null;
    public int     $version;          // Optimistic Locking
    public string  $bookedAt;

    // Additional fields for Admin View
    public ?string $userName = null;
    public ?string $userEmail = null;
    public ?string $movieTitle = null;
    public ?string $roomName = null;
    public ?string $showDate = null;
    public ?string $startTime = null;

    public function isHolding(): bool
    {
        return $this->status === 'holding';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isExpired(): bool
    {
        return $this->isHolding()
            && $this->holdExpiryTime !== null
            && strtotime($this->holdExpiryTime) < time();
    }
}
