# Mogmaa (Refactored Backend)

This is a cleaned, more secure version of your PHP backend with a consistent layout (header/footer/navigation), CSRF protection, prepared statements, and enhanced QR/WhatsApp utilities.

## Setup
1. Copy the contents of this folder to your server (replace or deploy alongside your old app).
2. Configure database credentials via environment variables:
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`
   (defaults: localhost / project / root / empty)
3. Ensure your database has tables `users` and `employees` (or update queries accordingly).
4. Visit `login.php` to sign in.

## Highlights
- Centralized PDO connection: `includes/db.php`
- CSRF + Flash + Auth helpers: `includes/functions.php`
- Consistent layout: `includes/header.php`, `includes/footer.php`
- Hardened endpoints: `login.php`, `send_whatsapp.php`, `edit.php`, etc.
- QR UI wrapper: `qr.php` (uses your existing `generate_qr.php` endpoint)
- WhatsApp UI: `whatsapp.php` (validates inputs and redirects to `wa.me`)

## Notes
- `login_process.php` remains for compatibility and now routes through `login.php`.
- Passwords: supports legacy plaintext on first login, then auto-upgrades to secure hash.
- Update table/column names in queries if your schema differs.
