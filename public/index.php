<?php

/**
 * Front controller. Dispatches to server.php (SSR) or api.php (JSON).
 *
 * Finds the app code in whichever layout applies:
 *   - dev `php -S -t public public/index.php`  -> server.php in the parent dir
 *   - Hetzner single-folder deploy             -> app code in ./app (see DEPLOY.md)
 *   - flat deploy                              -> server.php alongside index.php
 *
 * Under Apache, static assets + access control are handled by .htaccess; this
 * file only routes requests and marks itself as the legitimate entry point.
 */

define('PHPX_ENTRY', 1);

$base = __DIR__;
foreach ([__DIR__ . '/app', dirname(__DIR__), __DIR__] as $candidate) {
    if (is_file($candidate . '/server.php')) {
        $base = $candidate;
        break;
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Dev only: let the built-in server stream real static files (css, build/*) itself.
if (PHP_SAPI === 'cli-server' && $uri !== '/' && is_file(__DIR__ . $uri)) {
    return false;
}

if (strncmp($uri, '/api/', 5) === 0) {
    require $base . '/api.php';
    return;
}

require $base . '/server.php';
