<?php
/**
 * OAuth Configuration Test Script
 * Run: php tests/test_oauth_config.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[$key] = $value;
    }
}

echo "=== OAuth Configuration Test ===\n\n";

// Test Google OAuth Config
echo "📧 Google OAuth Configuration:\n";
echo "------------------------------\n";
echo "Client ID: " . ($_ENV['GOOGLE_CLIENT_ID'] ?? '❌ NOT SET') . "\n";
echo "Client Secret: " . (isset($_ENV['GOOGLE_CLIENT_SECRET']) && !empty($_ENV['GOOGLE_CLIENT_SECRET']) ? '✅ SET' : '❌ NOT SET') . "\n";
echo "Redirect URI: " . ($_ENV['GOOGLE_REDIRECT_URI'] ?? '❌ NOT SET') . "\n\n";

// Test Zalo OAuth Config
echo "💬 Zalo OAuth Configuration:\n";
echo "------------------------------\n";
echo "App ID: " . ($_ENV['ZALO_APP_ID'] ?? '❌ NOT SET') . "\n";
echo "App Secret: " . (isset($_ENV['ZALO_APP_SECRET']) && !empty($_ENV['ZALO_APP_SECRET']) ? '✅ SET' : '❌ NOT SET') . "\n";
echo "Redirect URI: " . ($_ENV['ZALO_REDIRECT_URI'] ?? '❌ NOT SET') . "\n\n";

// Test OAuthService
use App\Models\Services\OAuthService;

try {
    $oauthService = new OAuthService();
    
    echo "🔗 Generated OAuth URLs:\n";
    echo "------------------------------\n";
    
    // Test Google URL
    try {
        $googleUrl = $oauthService->getGoogleAuthUrl();
        echo "Google Auth URL:\n";
        echo $googleUrl . "\n\n";
    } catch (Exception $e) {
        echo "❌ Google URL Error: " . $e->getMessage() . "\n\n";
    }
    
    // Test Zalo URL
    try {
        $zaloUrl = $oauthService->getZaloAuthUrl();
        echo "Zalo Auth URL:\n";
        echo $zaloUrl . "\n\n";
    } catch (Exception $e) {
        echo "❌ Zalo URL Error: " . $e->getMessage() . "\n\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error initializing OAuthService: " . $e->getMessage() . "\n\n";
}

// Test cURL availability
echo "🔧 System Requirements:\n";
echo "------------------------------\n";
echo "cURL Extension: " . (extension_loaded('curl') ? '✅ Enabled' : '❌ Disabled') . "\n";
echo "OpenSSL Extension: " . (extension_loaded('openssl') ? '✅ Enabled' : '❌ Disabled') . "\n";
echo "JSON Extension: " . (extension_loaded('json') ? '✅ Enabled' : '❌ Disabled') . "\n\n";

// Test Database Connection
echo "💾 Database Configuration:\n";
echo "------------------------------\n";
echo "DB Host: " . ($_ENV['DB_HOST'] ?? '❌ NOT SET') . "\n";
echo "DB Name: " . ($_ENV['DB_NAME'] ?? '❌ NOT SET') . "\n";
echo "DB User: " . ($_ENV['DB_USERNAME'] ?? '❌ NOT SET') . "\n\n";

// Recommendations
echo "📝 Recommendations:\n";
echo "------------------------------\n";

$recommendations = [];

if (!isset($_ENV['GOOGLE_CLIENT_ID']) || empty($_ENV['GOOGLE_CLIENT_ID'])) {
    $recommendations[] = "Set up Google OAuth credentials in .env file";
}

if (!isset($_ENV['ZALO_APP_ID']) || empty($_ENV['ZALO_APP_ID'])) {
    $recommendations[] = "Set up Zalo OAuth credentials in .env file";
}

if (!extension_loaded('curl')) {
    $recommendations[] = "Enable cURL extension in php.ini";
}

if (empty($recommendations)) {
    echo "✅ All configurations look good!\n";
} else {
    foreach ($recommendations as $i => $rec) {
        echo ($i + 1) . ". " . $rec . "\n";
    }
}

echo "\n=== Test Complete ===\n";
