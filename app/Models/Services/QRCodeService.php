<?php

namespace App\Models\Services;

/**
 * QR Code Service using Google Charts API
 * Simple implementation without external dependencies
 */
class QRCodeService
{
    private const GOOGLE_CHART_API = 'https://chart.googleapis.com/chart';
    private int $size;
    
    public function __construct(int $size = 300)
    {
        $this->size = $size;
    }

    /**
     * Generate QR Code URL for ticket
     * 
     * @param int $ticketId
     * @param string $bookingCode
     * @return string QR Code image URL
     */
    public function generateTicketQR(int $ticketId, string $bookingCode): string
    {
        // Construct ticket verification data
        $data = $this->buildTicketData($ticketId, $bookingCode);
        
        return $this->generateQRUrl($data);
    }

    /**
     * Generate QR Code image URL
     * 
     * @param string $data Data to encode
     * @return string
     */
    public function generateQRUrl(string $data): string
    {
        $params = http_build_query([
            'cht' => 'qr',
            'chs' => "{$this->size}x{$this->size}",
            'chl' => $data,
            'choe' => 'UTF-8'
        ]);

        return self::GOOGLE_CHART_API . '?' . $params;
    }

    /**
     * Build ticket verification data
     * Format: TICKET-{id}-{booking_code}-{hash}
     * 
     * @param int $ticketId
     * @param string $bookingCode
     * @return string
     */
    private function buildTicketData(int $ticketId, string $bookingCode): string
    {
        // Create verification hash
        $secret = $_ENV['APP_SECRET'] ?? 'default_secret_change_me';
        $hash = substr(hash_hmac('sha256', "{$ticketId}:{$bookingCode}", $secret), 0, 8);
        
        return "TICKET-{$ticketId}-{$bookingCode}-{$hash}";
    }

    /**
     * Verify ticket QR code data
     * 
     * @param string $qrData QR code data scanned
     * @return array|null ['ticket_id' => int, 'booking_code' => string] or null if invalid
     */
    public function verifyTicketQR(string $qrData): ?array
    {
        // Parse QR data: TICKET-{id}-{booking_code}-{hash}
        if (!preg_match('/^TICKET-(\d+)-([A-Z0-9]+)-([a-f0-9]{8})$/', $qrData, $matches)) {
            return null;
        }

        [$_, $ticketId, $bookingCode, $providedHash] = $matches;

        // Verify hash
        $secret = $_ENV['APP_SECRET'] ?? 'default_secret_change_me';
        $expectedHash = substr(hash_hmac('sha256', "{$ticketId}:{$bookingCode}", $secret), 0, 8);

        if ($providedHash !== $expectedHash) {
            return null;
        }

        return [
            'ticket_id' => (int)$ticketId,
            'booking_code' => $bookingCode
        ];
    }

    /**
     * Generate verification URL for ticket
     * 
     * @param int $ticketId
     * @param string $bookingCode
     * @return string
     */
    public function generateVerificationUrl(int $ticketId, string $bookingCode): string
    {
        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost:8000';
        return "{$baseUrl}/tickets/verify?code=" . urlencode($this->buildTicketData($ticketId, $bookingCode));
    }
}
