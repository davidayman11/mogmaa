<?php
// Base URL of your site WITH trailing slash
// Match your host
const BASE_URL = 'http://mogamaaa.shamandorascout.com/';

// Directory (filesystem) and URL for QR images
const QR_DIR = __DIR__ . '/../qr_codes/';
const QR_URL = BASE_URL . 'qr_codes/';

// Secret key for signing tickets (change to a long random string!)
const APP_SECRET = 'change_this_to_a_long_random_secret_string_32+chars';

// Admin credentials (per your request to hardcode)
const ADMIN_USER = 'admin';
const ADMIN_PASS = 'password'; // change after first login!

// Helper: build absolute URL for any path relative to project root
function url(string $path): string {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
?>
