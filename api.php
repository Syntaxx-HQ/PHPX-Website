<?php

/**
 * Tiny JSON API for the live data-fetching examples (useData / useSuspenseData).
 * Shares its data with the example components so server and client agree.
 */

// Only reachable through the front controller (index.php) or CLI. Blocks direct
// web access even if a server misconfig bypasses .htaccess.
if (PHP_SAPI !== 'cli' && !defined('PHPX_ENTRY')) {
    http_response_code(403);
    exit('Forbidden');
}

require __DIR__ . '/vendor/autoload.php';

// The compiler writes to STDOUT/STDERR (defined in CLI, not under the web SAPI).
if (!defined('STDOUT')) {
    define('STDOUT', fopen('php://stdout', 'wb'));
}
if (!defined('STDERR')) {
    define('STDERR', fopen('php://stderr', 'wb'));
}

header('Content-Type: application/json');

$path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

if ($path === '/api/compile') {
    // The PHPX compiler runs reliably here (native PHP). The browser then evals
    // and renders the returned PHP live. Input is raw PHPX (no opening tag).
    // The compiler only *parses* the input (never executes it on the server);
    // cap the size so a huge payload cannot exhaust the parser.
    $code = file_get_contents('php://input');
    if (strlen($code) > 100000) {
        echo json_encode(['error' => 'Source too large (100 KB max).']);
        return;
    }
    try {
        $php = (new \Syntaxx\PHPX\Compiler())->compileString("<?php\n" . $code, 'playground.phpx');
        $php = preg_replace('/^\s*<\?php\s*/', '', $php);
        echo json_encode(['php' => $php]);
    } catch (\Throwable $e) {
        echo json_encode(['error' => get_class($e) . ': ' . $e->getMessage()]);
    }
    return;
}

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
