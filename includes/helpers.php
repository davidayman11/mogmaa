<?php
require_once __DIR__ . '/../config/app.php';

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function normalize_phone(string $p): string {
    $p = preg_replace('/\D+/', '', $p);
    // Ensure Egypt code if starts with 0 or 1x etc.
    if (strpos($p, '20') === 0) return $p; // already +20 without plus
    if (strpos($p, '0020') === 0) return substr($p, 2);
    if (strpos($p, '0') === 0) return '20' . substr($p, 1);
    if (strpos($p, '+') === 0) return ltrim($p, '+');
    return $p; // as is
}

function make_signature(string $id): string {
    return hash_hmac('sha256', $id, APP_SECRET);
}

function build_ticket_url(string $id): string {
    $sig = make_signature($id);
    return url('public/ticket.php?id=' . urlencode($id) . '&sig=' . $sig);
}

function ensure_qr_dir(): void {
    if (!is_dir(QR_DIR)) {
        @mkdir(QR_DIR, 0775, true);
    }
}

function qr_filename(string $id): string {
    $sig = substr(make_signature($id), 0, 12);
    return 'mogamaa_' . preg_replace('/[^A-Za-z0-9]/', '', $id) . '_' . $sig . '.png';
}
?>
