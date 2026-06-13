<?php

namespace App\Models\Services\Implementations;

use App\Models\Services\Interfaces\IEmailService;

/**
 * Email Service using PHP mail() or SMTP
 * For production, use PHPMailer or similar library
 */
class EmailService implements IEmailService
{
    private string $fromEmail;
    private string $fromName;
    private bool $useSMTP;

    public function __construct()
    {
        $this->fromEmail = $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@cinemax.vn';
        $this->fromName = $_ENV['MAIL_FROM_NAME'] ?? 'CinemaX';
        $this->useSMTP = ($_ENV['MAIL_MAILER'] ?? 'mail') === 'smtp';
    }

    public function send(string $to, string $subject, string $body): bool
    {
        $headers = $this->buildHeaders();

        if ($this->useSMTP) {
            return $this->sendViaSMTP($to, $subject, $body, $headers);
        }

        // Use PHP mail()
        return mail($to, $subject, $body, $headers);
    }

    public function sendBookingConfirmation(string $to, array $bookingData): bool
    {
        $subject = "Xác nhận đặt vé - Mã đặt: {$bookingData['booking_code']}";
        $body = $this->renderBookingTemplate($bookingData);

        return $this->send($to, $subject, $body);
    }

    public function sendPasswordReset(string $to, string $resetToken): bool
    {
        $subject = "Đặt lại mật khẩu - CinemaX";
        $resetUrl = ($_ENV['APP_URL'] ?? 'http://localhost:8000') . "/reset-password?token={$resetToken}";
        
        $body = $this->renderPasswordResetTemplate($resetUrl);

        return $this->send($to, $subject, $body);
    }

    public function sendPromotionNotification(string $to, array $promotionData): bool
    {
        $subject = "Khuyến mãi đặc biệt - {$promotionData['code']}";
        $body = $this->renderPromotionTemplate($promotionData);

        return $this->send($to, $subject, $body);
    }

    private function buildHeaders(): string
    {
        $headers = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $headers[] = "From: {$this->fromName} <{$this->fromEmail}>";
        $headers[] = "Reply-To: {$this->fromEmail}";
        $headers[] = "X-Mailer: PHP/" . phpversion();

        return implode("\r\n", $headers);
    }

    private function sendViaSMTP(string $to, string $subject, string $body, string $headers): bool
    {
        // TODO: Implement SMTP sending using PHPMailer or similar
        // For now, fallback to mail()
        return mail($to, $subject, $body, $headers);
    }

    private function renderBookingTemplate(array $data): string
    {
        $bookingCode = htmlspecialchars($data['booking_code']);
        $movieTitle = htmlspecialchars($data['movie_title']);
        $cinemaName = htmlspecialchars($data['cinema_name']);
        $showtime = htmlspecialchars($data['showtime']);
        $seats = htmlspecialchars($data['seats']);
        $totalPrice = number_format($data['total_price']);

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .ticket-info { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #e50914; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .button { display: inline-block; padding: 12px 30px; background: #e50914; color: white; text-decoration: none; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎬 CinemaX</h1>
            <p>Xác nhận đặt vé thành công</p>
        </div>
        
        <div class="content">
            <h2>Xin chào!</h2>
            <p>Cảm ơn bạn đã đặt vé tại CinemaX. Dưới đây là thông tin vé của bạn:</p>
            
            <div class="ticket-info">
                <p><strong>Mã đặt vé:</strong> {$bookingCode}</p>
                <p><strong>Phim:</strong> {$movieTitle}</p>
                <p><strong>Rạp:</strong> {$cinemaName}</p>
                <p><strong>Suất chiếu:</strong> {$showtime}</p>
                <p><strong>Ghế:</strong> {$seats}</p>
                <p><strong>Tổng tiền:</strong> {$totalPrice}đ</p>
            </div>
            
            <p style="text-align: center;">
                <a href="{$_ENV['APP_URL']}/tickets/{$bookingCode}" class="button">Xem vé của tôi</a>
            </p>
            
            <p><strong>Lưu ý quan trọng:</strong></p>
            <ul>
                <li>Vui lòng đến rạp trước 15 phút để check-in</li>
                <li>Xuất trình mã QR hoặc mã đặt vé tại quầy</li>
                <li>Giữ vé cẩn thận để tránh thất lạc</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>© 2024 CinemaX. All rights reserved.</p>
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function renderPasswordResetTemplate(string $resetUrl): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .button { display: inline-block; padding: 12px 30px; background: #e50914; color: white; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Đặt lại mật khẩu</h1>
        </div>
        
        <div class="content">
            <h2>Xin chào!</h2>
            <p>Bạn đã yêu cầu đặt lại mật khẩu cho tài khoản CinemaX.</p>
            <p>Vui lòng nhấn vào nút bên dưới để tiếp tục:</p>
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="{$resetUrl}" class="button">Đặt lại mật khẩu</a>
            </p>
            
            <p><strong>Lưu ý:</strong></p>
            <ul>
                <li>Link này chỉ có hiệu lực trong 60 phút</li>
                <li>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>© 2024 CinemaX. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function renderPromotionTemplate(array $data): string
    {
        $code = htmlspecialchars($data['code']);
        $description = htmlspecialchars($data['description']);
        $discount = htmlspecialchars($data['discount_value']);
        $validTo = htmlspecialchars(date('d/m/Y', strtotime($data['valid_to'])));

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #e50914; color: white; padding: 30px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .promo-code { background: #fff; border: 2px dashed #e50914; padding: 20px; text-align: center; margin: 20px 0; font-size: 24px; font-weight: bold; color: #e50914; }
        .button { display: inline-block; padding: 12px 30px; background: #e50914; color: white; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Khuyến mãi đặc biệt!</h1>
            <p>Ưu đãi dành riêng cho bạn</p>
        </div>
        
        <div class="content">
            <h2>Giảm giá {$discount}%</h2>
            <p>{$description}</p>
            
            <div class="promo-code">
                {$code}
            </div>
            
            <p><strong>Cách sử dụng:</strong></p>
            <ol>
                <li>Chọn phim và suất chiếu yêu thích</li>
                <li>Nhập mã <strong>{$code}</strong> khi thanh toán</li>
                <li>Tận hưởng ưu đãi ngay lập tức!</li>
            </ol>
            
            <p style="text-align: center;">
                <a href="{$_ENV['APP_URL']}/movies" class="button">Đặt vé ngay</a>
            </p>
            
            <p style="color: #999; font-size: 14px;">
                <em>* Mã có hiệu lực đến {$validTo}</em>
            </p>
        </div>
        
        <div class="footer">
            <p>© 2024 CinemaX. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
