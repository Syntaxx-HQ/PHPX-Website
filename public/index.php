<?php

/**
 * Dev router for `php -S`. Real files under public/ (css, build/*.mjs/.wasm/.data)
 * are served directly; /api/* hits api.php; every other path is server-rendered.
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

if ($uri !== '/' && is_file($file)) {
    return false; // let the built-in server serve the static asset
}

if (strncmp($uri, '/api/', 5) === 0) {
    require __DIR__ . '/../api.php';
    return true;
}

require __DIR__ . '/../server.php';
