<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '', true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

if (!empty($input['website'] ?? '')) {
    echo json_encode(['type' => 'OK', 'budgetStr' => '—', 'timelineStr' => '—']);
    exit;
}

if (!rate_limit_allow('estimate_wizard', 30, 3600)) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many requests. Please try again in a few minutes.']);
    exit;
}

$type = $input['type'] ?? '';
$scale = $input['scale'] ?? '';
$features = $input['features'] ?? [];
$integrations = $input['integrations'] ?? [];
$name = trim((string)($input['name'] ?? ''));
$email = trim((string)($input['email'] ?? ''));
$company = trim((string)($input['company'] ?? ''));
$idea = trim((string)($input['idea'] ?? ''));
$phone = trim((string)($input['phone'] ?? ''));

if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Name and a valid email are required']);
    exit;
}

if (!is_array($features)) {
    $features = [];
}
if (!is_array($integrations)) {
    $integrations = [];
}

$COST_TABLE = [
    'Website' => [0.8, 3.0, 4, 10],
    'Web App' => [3.0, 9.0, 8, 18],
    'Mobile App' => [4.0, 12.0, 10, 22],
    'ERP' => [9.0, 30.0, 20, 44],
    'CRM' => [5.0, 16.0, 12, 28],
    'TMS' => [7.0, 20.0, 14, 32],
    'HMS' => [9.0, 26.0, 20, 42],
    'Hotel PMS' => [6.0, 18.0, 14, 32],
    'Finance Software' => [5.0, 15.0, 12, 26],
    'IoT/Embedded' => [8.0, 24.0, 18, 40],
];

$SCALE_MULTIPLIER = ['Small' => 0.6, 'Medium' => 1.0, 'Large' => 1.55];
$FEATURE_WEIGHT = 0.06;
$INT_WEIGHT = 0.05;

$TECH_MAP = [
    'Website' => 'React.js front-end · Laravel / Node.js back-end · MySQL · Hostinger / AWS',
    'Web App' => 'React.js SPA · Laravel REST API · MySQL · Redis · AWS EC2 / S3',
    'Mobile App' => 'Flutter (cross-platform) or React Native · Node.js / Laravel API · Firebase / AWS',
    'ERP' => 'React.js · Laravel PHP · MySQL · Redis · Docker · AWS / DigitalOcean',
    'CRM' => 'React.js · Node.js · PostgreSQL · Redis · AWS / Azure',
    'TMS' => 'React.js · Node.js · MySQL · Google Maps API · AWS',
    'HMS' => 'React.js · Laravel · MySQL · HL7/FHIR ready · AWS',
    'Hotel PMS' => 'React.js · Node.js · PostgreSQL · Channel Manager APIs · AWS',
    'Finance Software' => 'React.js · Laravel · MySQL · Tally API connector · AWS',
    'IoT/Embedded' => 'C/C++ firmware (Keil / Arduino) · MQTT broker · Node.js gateway · InfluxDB · AWS IoT Core',
];

$base = $COST_TABLE[$type] ?? [3, 10, 8, 20];
$sm = $SCALE_MULTIPLIER[$scale] ?? 1;
$fm = 1 + count($features) * $FEATURE_WEIGHT;
$im = 1 + count($integrations) * $INT_WEIGHT;
$mul = $sm * $fm * $im;

$minC = round($base[0] * $mul, 1);
$maxC = round($base[1] * $mul, 1);
$minW = (int)round($base[2] * $sm);
$maxW = (int)round($base[3] * $sm * $fm * $im);

$budgetStr = "₹{$minC}L – ₹{$maxC}L";
$timelineStr = "{$minW}–{$maxW} weeks";
$complexStr = $scale === 'Large' ? 'High' : ($scale === 'Medium' ? 'Medium' : 'Standard');

$featureList = !empty($features)
    ? implode("\n", array_map(static fn($f) => '  • ' . $f, $features))
    : "  • Core functionality (no additional modules selected)";
$intList = !empty($integrations)
    ? implode("\n", array_map(static fn($i) => '  • ' . $i, $integrations))
    : "  • No third-party integrations required";

$clientNameDisplay = $name . ($company ? ' from ' . $company : '');
$summary = ($name ? $clientNameDisplay . ' is' : 'Client is') . " looking to build a " . strtolower($scale) . "-scale " . $type . " solution." . ($idea ? ' Their core idea: "' . $idea . '"' : '') . "\n\nThis is a " . strtolower($complexStr) . "-complexity engagement with an estimated budget range of {$budgetStr} and delivery timeline of {$timelineStr}.";

$scopeUsers = $scale === 'Small' ? 'up to 25' : ($scale === 'Medium' ? '25–200' : '200+');
$scope = "Scale: {$scale} ({$scopeUsers} users)\n\nKey Features Requested:\n{$featureList}\n\nIntegrations Required:\n{$intList}";

$tech = $TECH_MAP[$type] ?? 'React.js · Node.js / Laravel · MySQL · AWS';

$notes = "• Budget figures are indicative and in Indian Rupees (Lakhs). Final quotes depend on detailed scope.\n• Timeline assumes a dedicated team and regular client availability for reviews.\n• Maintenance and hosting costs are not included in the above estimate.\n• Dashandots typically starts with a 1–2 week discovery phase before committing to a fixed-price quote.";

$briefText = "PROJECT BRIEF — {$type} ({$scale} scale)\n\n{$summary}\n\n--- FEATURES ---\n{$featureList}\n\n--- INTEGRATIONS ---\n{$intList}\n\n--- TECH STACK ---\n{$tech}\n\n--- ESTIMATE ---\nBudget: {$budgetStr}\nTimeline: {$timelineStr}";

echo json_encode([
    'type' => $type,
    'clientName' => $name . ($company ? ' · ' . $company : ''),
    'budgetMin' => $minC,
    'budgetMax' => $maxC,
    'budgetStr' => $budgetStr,
    'timelineStr' => $timelineStr,
    'complexity' => $complexStr,
    'summary' => $summary,
    'scope' => $scope,
    'tech' => $tech,
    'notes' => $notes,
    'briefText' => $briefText,
]);
