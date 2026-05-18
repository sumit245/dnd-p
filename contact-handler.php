<?php
/**
 * Dashandots Technology — Contact Form Handler
 * ─────────────────────────────────────────────
 * Self-contained SMTP mailer — NO Composer / PHPMailer needed.
 * Uses Gmail SSL (port 465) via PHP's native stream_socket_client().
 *
 * SETUP:
 *   1. Open .env (same folder as this file)
 *   2. Replace SMTP_PASS with your Gmail App Password (16 chars, no spaces)
 *      Get one at: https://myaccount.google.com/apppasswords
 *   3. Save — done.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$corsOrigin = contact_cors_origin();
if ($corsOrigin !== '') {
    header('Access-Control-Allow-Origin: ' . $corsOrigin);
    header('Vary: Origin');
}
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

/* ── Load .env ─────────────────────────────────────────────────────────── */
function load_env(string $path): void {
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $val] = array_map('trim', explode('=', $line, 2));
        if ($key !== '') $_ENV[$key] = $val;
    }
}

load_env(__DIR__ . '/.env');

$SMTP_HOST = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
$SMTP_PORT = (int)($_ENV['SMTP_PORT'] ?? 465);
$SMTP_USER = $_ENV['SMTP_USER'] ?? '';
$SMTP_PASS = $_ENV['SMTP_PASS'] ?? '';
$TO_EMAIL  = $_ENV['TO_EMAIL']  ?? $SMTP_USER;
$TO_NAME   = $_ENV['TO_NAME']   ?? 'Dashandots Technology';
$FROM_NAME = $_ENV['FROM_NAME'] ?? 'Dashandots Website';

/* ── Read & validate input ─────────────────────────────────────────────── */
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) $data = $_POST ?: null;

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request payload']);
    exit;
}

// Honeypot — bots often fill hidden fields
if (!empty($data['website'] ?? '')) {
    echo json_encode(['success' => true, 'message' => 'Thanks! We\'ll be in touch within 24 hours.']);
    exit;
}

if (!rate_limit_allow('contact_form', 5, 3600)) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please try again later or email us directly.']);
    exit;
}

function s(string $v): string {
    return htmlspecialchars(strip_tags(trim($v)), ENT_QUOTES, 'UTF-8');
}

$name    = s((string)($data['name']    ?? ''));
$email   = s((string)($data['email']   ?? ''));
$company = s((string)($data['company'] ?? ''));
$phone   = s((string)($data['phone']   ?? ''));
$service = s((string)($data['service'] ?? ''));
$message = s((string)($data['message'] ?? ''));

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Name, email, and message are required.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}
if (strlen($message) < 10) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Message is too short.']);
    exit;
}
if (empty($SMTP_PASS) || $SMTP_PASS === 'YOUR_16_CHAR_APP_PASSWORD_HERE') {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Email service not configured. Open .env and set SMTP_PASS to your Gmail App Password.']);
    exit;
}

/* ── Email content builders ────────────────────────────────────────────── */
function make_enquiry_html(string $name, string $email, string $company, string $phone, string $service, string $message): string {
    $date = date('D, d M Y \a\t H:i');
    $co = $company ? "<div class='f'><div class='l'>Company</div><div class='v'>" . htmlspecialchars($company) . "</div></div>" : '';
    $ph = $phone   ? "<div class='f'><div class='l'>Phone</div><div class='v'>"   . htmlspecialchars($phone)   . "</div></div>" : '';
    $sv = $service ? "<div class='f'><div class='l'>Service</div><div class='v'>" . htmlspecialchars($service) . "</div></div>" : '';
    return "<!DOCTYPE html><html><head><meta charset='UTF-8'>
<style>
 body{font-family:Arial,sans-serif;background:#f5f4f0;margin:0;padding:20px;color:#111}
 .card{background:#fff;border-radius:12px;padding:32px;max-width:600px;margin:0 auto;border:1px solid #e8e6e0}
 .hd{border-bottom:3px solid #C8293E;padding-bottom:14px;margin-bottom:22px}
 .brand{color:#C8293E;font-size:18px;font-weight:700}
 h2{font-size:20px;margin:4px 0 2px}
 .dt{color:#999;font-size:12px}
 .f{margin-bottom:14px}
 .l{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#999;margin-bottom:3px}
 .v{font-size:14px;padding:10px 13px;background:#fafaf8;border-radius:7px;border:1px solid #e8e6e0;word-break:break-word}
 .msg{white-space:pre-wrap;line-height:1.65}
 .ft{margin-top:22px;padding-top:14px;border-top:1px solid #e8e6e0;font-size:11px;color:#bbb}
</style></head><body>
<div class='card'>
 <div class='hd'><div class='brand'>Dashandots Technology</div><h2>New Project Enquiry</h2><div class='dt'>Received {$date} IST</div></div>
 <div class='f'><div class='l'>Name</div><div class='v'>" . htmlspecialchars($name) . "</div></div>
 <div class='f'><div class='l'>Email</div><div class='v'><a href='mailto:{$email}'>" . htmlspecialchars($email) . "</a></div></div>
 {$co}{$ph}{$sv}
 <div class='f'><div class='l'>Message</div><div class='v msg'>" . nl2br(htmlspecialchars($message)) . "</div></div>
 <div class='ft'>Sent via dashandots.com — reply to this email to respond to {$name}.</div>
</div></body></html>";
}

function make_confirm_html(string $name): string {
    return "<!DOCTYPE html><html><head><meta charset='UTF-8'>
<style>body{font-family:Arial,sans-serif;color:#111;padding:28px;max-width:560px;margin:0 auto}h2{color:#C8293E}p{line-height:1.7;color:#444}a{color:#C8293E}small{color:#aaa}</style>
</head><body>
<h2>Thank you, " . htmlspecialchars($name) . "!</h2>
<p>We've received your enquiry and will get back to you <strong>within 24 hours</strong> (Mon–Fri).</p>
<p>In the meantime, browse our <a href='https://dashandots.com/#portfolio'>portfolio</a> or read our <a href='https://dashandots.com/#faq'>FAQ</a>.</p>
<hr style='border:none;border-top:1px solid #e8e6e0;margin:24px 0'>
<small>Dashandots Technology &mdash; <a href='https://dashandots.com'>dashandots.com</a></small>
</body></html>";
}

/* ── Self-contained SMTP client (SSL port 465, no external deps) ────────── */
function smtp_send(
    string $host, int $port,
    string $user, string $pass,
    string $fromEmail, string $fromName,
    string $toEmail,   string $toName,
    string $subject,   string $htmlBody,
    string $textBody,  string $replyTo = ''
): void {
    $ctx  = stream_context_create(['ssl' => [
        'verify_peer'       => true,
        'verify_peer_name'  => true,
        'allow_self_signed' => false,
    ]]);
    $sock = @stream_socket_client("ssl://{$host}:{$port}", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $ctx);
    if (!$sock) throw new RuntimeException("SMTP connect failed [{$errno}]: {$errstr}");
    stream_set_timeout($sock, 20);

    $read = function() use ($sock): string {
        $out = '';
        while (!feof($sock)) {
            $line = fgets($sock, 512);
            if ($line === false) break;
            $out .= $line;
            if (strlen($line) >= 4 && $line[3] === ' ') break;
        }
        return $out;
    };
    $cmd = function(string $c) use ($sock, $read): string {
        fwrite($sock, $c . "\r\n");
        return $read();
    };
    $ok = function(string $r, string $code): void {
        if (substr(trim($r), 0, 3) !== $code)
            throw new RuntimeException("SMTP error (expected {$code}): " . trim($r));
    };

    $ok($read(), '220');
    $ok($cmd('EHLO ' . (gethostname() ?: 'localhost')), '250');
    $ok($cmd('AUTH LOGIN'), '334');
    $ok($cmd(base64_encode($user)), '334');
    $ok($cmd(base64_encode($pass)), '235');
    $ok($cmd("MAIL FROM:<{$fromEmail}>"), '250');
    $ok($cmd("RCPT TO:<{$toEmail}>"), '250');
    $ok($cmd('DATA'), '354');

    $boundary = 'DDOTS_' . md5(uniqid((string)rand(), true));
    $replyLine = $replyTo ? "Reply-To: {$replyTo}\r\n" : '';
    $subjectEncoded = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    $msg =
        "From: {$fromName} <{$fromEmail}>\r\n" .
        "To: {$toName} <{$toEmail}>\r\n" .
        $replyLine .
        "Subject: {$subjectEncoded}\r\n" .
        "MIME-Version: 1.0\r\n" .
        "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n" .
        "Date: " . date('r') . "\r\n" .
        "X-Mailer: Dashandots-Mailer/1.0\r\n\r\n" .
        "--{$boundary}\r\n" .
        "Content-Type: text/plain; charset=UTF-8\r\n" .
        "Content-Transfer-Encoding: base64\r\n\r\n" .
        chunk_split(base64_encode($textBody)) . "\r\n" .
        "--{$boundary}\r\n" .
        "Content-Type: text/html; charset=UTF-8\r\n" .
        "Content-Transfer-Encoding: base64\r\n\r\n" .
        chunk_split(base64_encode($htmlBody)) . "\r\n" .
        "--{$boundary}--\r\n";

    // RFC 2821 dot-stuffing
    $msg = preg_replace('/^\.$/m', '..', $msg);
    fwrite($sock, $msg . "\r\n.\r\n");
    $ok($read(), '250');
    $cmd('QUIT');
    fclose($sock);
}

/* ── Send ──────────────────────────────────────────────────────────────── */
$subject  = "New enquiry from {$name}" . ($company ? " ({$company})" : '') . " — Dashandots";
$htmlBody = make_enquiry_html($name, $email, $company, $phone, $service, $message);
$textBody = "New enquiry — Dashandots\n\nName: {$name}\nEmail: {$email}"
          . ($company ? "\nCompany: {$company}" : '')
          . ($phone   ? "\nPhone: {$phone}"     : '')
          . ($service ? "\nService: {$service}" : '')
          . "\n\nMessage:\n{$message}\n\n—\nReceived: " . date('D d M Y H:i') . " IST";

$sent = false;
$errMsg = '';

try {
    // Enquiry to Dashandots
    smtp_send(
        $SMTP_HOST, $SMTP_PORT,
        $SMTP_USER, $SMTP_PASS,
        $SMTP_USER, $FROM_NAME,
        $TO_EMAIL, $TO_NAME,
        $subject, $htmlBody, $textBody,
        "{$name} <{$email}>"
    );
    // Confirmation to enquirer
    smtp_send(
        $SMTP_HOST, $SMTP_PORT,
        $SMTP_USER, $SMTP_PASS,
        $SMTP_USER, $TO_NAME,
        $email, $name,
        "We've received your enquiry — Dashandots Technology",
        make_confirm_html($name),
        "Thank you {$name}! We'll reply within 24 hours. — Dashandots Technology"
    );
    $sent = true;
} catch (RuntimeException $e) {
    $errMsg = $e->getMessage();
    error_log("[Dashandots Contact] SMTP failed for <{$email}>: {$errMsg}");
}

/* ── Response ──────────────────────────────────────────────────────────── */
if ($sent) {
    echo json_encode(['success' => true,  'message' => "Thanks {$name}! We'll be in touch within 24 hours."]);
} else {
    http_response_code(500);
    $hint = str_contains($errMsg, 'connect') || str_contains($errMsg, 'ssl')
        ? 'SMTP connection failed — check SMTP_PASS in .env is your Gmail App Password (no spaces).'
        : $errMsg;
    echo json_encode(['success' => false, 'message' => "Could not send email. {$hint}"]);
}
