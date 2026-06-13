<?php
// app/helpers.php - Global Helper Functions

use App\Core\CsrfProtection;

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF token hidden input field
     * @return string
     */
    function csrf_field(): string
    {
        return CsrfProtection::field();
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get CSRF token value
     * @return string
     */
    function csrf_token(): string
    {
        return CsrfProtection::generate();
    }
}

if (!function_exists('is_oauth_user')) {
    /**
     * Check if current user is OAuth user
     * @return bool
     */
    function is_oauth_user(): bool
    {
        return isset($_SESSION['oauth_provider']) && !empty($_SESSION['oauth_provider']);
    }
}

if (!function_exists('get_oauth_provider')) {
    /**
     * Get OAuth provider of current user
     * @return string|null
     */
    function get_oauth_provider(): ?string
    {
        return $_SESSION['oauth_provider'] ?? null;
    }
}

if (!function_exists('format_oauth_provider')) {
    /**
     * Format OAuth provider name for display
     * @param string $provider
     * @return string
     */
    function format_oauth_provider(string $provider): string
    {
        return match($provider) {
            'google' => 'Google',
            'zalo' => 'Zalo',
            default => ucfirst($provider),
        };
    }
}

// Slug generator
if (!function_exists('create_slug')) {
    function create_slug($string) {
        $search = array(
            '#(à|á|?|?|?|â|?|?|?|?|?|ã|?|?|?|?|?)#',
            '#(è|é|?|?|?|ê|?|?|?|?|?)#',
            '#(?|í|?|?|?)#',
            '#(?|ó|?|?|?|ô|?|?|?|?|?|õ|?|?|?|?|?)#',
            '#(ù|ú|?|?|?|ý|?|?|?|?|?)#',
            '#(?|?|?|?|?)#',
            '#(ð)#',
            '#(À|Á|?|?|?|Â|?|?|?|?|?|Ã|?|?|?|?|?)#',
            '#(È|É|?|?|?|Ê|?|?|?|?|?)#',
            '#(?|Í|?|?|?)#',
            '#(?|Ó|?|?|?|Ô|?|?|?|?|?|Õ|?|?|?|?|?)#',
            '#(Ù|Ú|?|?|?|Ý|?|?|?|?|?)#',
            '#(?|?|?|?|?)#',
            '#(Ð)#',
            '/[^a-zA-Z0-9\-\_]/'
        );
        $replace = array('a', 'e', 'i', 'o', 'u', 'y', 'd', 'A', 'E', 'I', 'O', 'U', 'Y', 'D', '-');
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return trim($string, '-');
    }
}
