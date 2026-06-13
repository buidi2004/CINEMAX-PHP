<?php

namespace App\Models\Services\Interfaces;

interface IEmailService
{
    /**
     * Send email
     * 
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $body Email body (HTML)
     * @return bool Success status
     */
    public function send(string $to, string $subject, string $body): bool;

    /**
     * Send booking confirmation email
     * 
     * @param string $to Customer email
     * @param array $bookingData Booking details
     * @return bool
     */
    public function sendBookingConfirmation(string $to, array $bookingData): bool;

    /**
     * Send password reset email
     * 
     * @param string $to User email
     * @param string $resetToken Reset token
     * @return bool
     */
    public function sendPasswordReset(string $to, string $resetToken): bool;

    /**
     * Send promotion notification
     * 
     * @param string $to User email
     * @param array $promotionData Promotion details
     * @return bool
     */
    public function sendPromotionNotification(string $to, array $promotionData): bool;
}
