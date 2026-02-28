<?php

/**
 * Tiny JSON API for the live data-fetching examples (useData / useSuspenseData).
 * Shares its data with the example components so server and client agree.
 */

require __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json');

$path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

if ($path === '/api/example-todos') {
    usleep(150000); // a little latency so loading states are visible
    echo json_encode([
        'Learn PHPX',
        'Build a component',
        'Ship it to production',
    ]);
    return;
}

http_response_code(404);
echo json_encode(['error' => 'not found']);
