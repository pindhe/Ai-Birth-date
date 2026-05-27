<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = '/' . trim($path, '/');
if ($path === '//') {
    $path = '/';
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($path === '/calculate' && $method === 'POST') {
    require __DIR__ . '/api/calculate.php';
    return true;
}

if ($path === '/api/calculate.php' && $method === 'POST') {
    require __DIR__ . '/api/calculate.php';
    return true;
}

$file = __DIR__ . $path;

if ($path !== '/' && is_file($file)) {
    return false;
}

require __DIR__ . '/index.php';
return true;
