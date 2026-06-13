<?php
namespace App\Models\Services;

use App\Core\Exceptions\BusinessException;

class OAuthService
{
    private string $googleClientId;
    private string $googleClientSecret;
    private string $googleRedirectUri;
    
    private string $zaloAppId;
    private string $zaloAppSecret;
    private string $zaloRedirectUri;

    public function __construct()
    {
        $this->googleClientId     = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
        $this->googleClientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
        $this->googleRedirectUri  = $_ENV['GOOGLE_REDIRECT_URI'] ?? '';
        
        $this->zaloAppId          = $_ENV['ZALO_APP_ID'] ?? '';
        $this->zaloAppSecret      = $_ENV['ZALO_APP_SECRET'] ?? '';
        $this->zaloRedirectUri    = $_ENV['ZALO_REDIRECT_URI'] ?? '';
    }

    // ============ GOOGLE OAUTH ============

    public function getGoogleAuthUrl(): string
    {
        $params = [
            'client_id'     => $this->googleClientId,
            'redirect_uri'  => $this->googleRedirectUri,
            'response_type' => 'code',
            'scope'         => 'email profile',
            'access_type'   => 'online',
        ];

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }

    public function getGoogleUserInfo(string $code): array
    {
        // Exchange code for access token
        $tokenData = $this->exchangeGoogleCode($code);
        
        if (!isset($tokenData['access_token'])) {
            throw new BusinessException('Không thể lấy access token từ Google');
        }

        // Get user info
        $ch = curl_init('https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $tokenData['access_token']
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new BusinessException('Không thể lấy thông tin user từ Google');
        }

        $userInfo = json_decode($response, true);

        return [
            'oauth_id'   => $userInfo['id'],
            'email'      => $userInfo['email'],
            'username'   => $userInfo['name'] ?? explode('@', $userInfo['email'])[0],
            'avatar_url' => $userInfo['picture'] ?? null,
        ];
    }

    private function exchangeGoogleCode(string $code): array
    {
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'code'          => $code,
                'client_id'     => $this->googleClientId,
                'client_secret' => $this->googleClientSecret,
                'redirect_uri'  => $this->googleRedirectUri,
                'grant_type'    => 'authorization_code',
            ]),
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true) ?? [];
    }

    // ============ ZALO OAUTH ============

    public function getZaloAuthUrl(): string
    {
        $params = [
            'app_id'       => $this->zaloAppId,
            'redirect_uri' => $this->zaloRedirectUri,
            'state'        => bin2hex(random_bytes(16)), // CSRF protection
        ];

        return 'https://oauth.zaloapp.com/v4/permission?' . http_build_query($params);
    }

    public function getZaloUserInfo(string $code): array
    {
        // Exchange code for access token
        $tokenData = $this->exchangeZaloCode($code);
        
        if (!isset($tokenData['access_token'])) {
            throw new BusinessException('Không thể lấy access token từ Zalo');
        }

        // Get user info
        $ch = curl_init('https://graph.zalo.me/v2.0/me?fields=id,name,picture');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'access_token: ' . $tokenData['access_token']
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new BusinessException('Không thể lấy thông tin user từ Zalo');
        }

        $userInfo = json_decode($response, true);

        // Zalo không trả về email, cần tạo email giả hoặc yêu cầu user nhập sau
        $email = 'zalo_' . $userInfo['id'] . '@placeholder.com';

        return [
            'oauth_id'   => $userInfo['id'],
            'email'      => $email, // Email giả, có thể yêu cầu user cập nhật sau
            'username'   => $userInfo['name'] ?? 'Zalo User',
            'avatar_url' => $userInfo['picture']['data']['url'] ?? null,
        ];
    }

    private function exchangeZaloCode(string $code): array
    {
        $ch = curl_init('https://oauth.zaloapp.com/v4/access_token');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'code'         => $code,
                'app_id'       => $this->zaloAppId,
                'app_secret'   => $this->zaloAppSecret,
                'grant_type'   => 'authorization_code',
            ]),
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true) ?? [];
    }
}
