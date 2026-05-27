<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Use POST.',
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    $input = $_POST;
}

$dob = trim($input['dob'] ?? '');

if ($dob === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid date of birth provided.',
    ]);
    exit;
}

$birth = DateTime::createFromFormat('Y-m-d', $dob);

if ($birth === false || $birth->format('Y-m-d') !== $dob) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid date of birth provided.',
    ]);
    exit;
}

$birth->setTime(0, 0, 0);
$now = new DateTime('now');

if ($birth > $now) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Date of birth cannot be in the future.',
    ]);
    exit;
}

$interval = $birth->diff($now);
$years = (int) $interval->y;

$diffSeconds = $now->getTimestamp() - $birth->getTimestamp();
$days = intdiv($diffSeconds, 86400);
$hours = intdiv($diffSeconds, 3600);
$minutes = intdiv($diffSeconds, 60);

echo json_encode([
    'success' => true,
    'dob' => $dob,
    'currentDate' => $now->format('c'),
    'age' => [
        'years' => $years,
        'days' => $days,
        'hours' => $hours,
        'minutes' => $minutes,
        'seconds' => $diffSeconds,
    ],
]);
