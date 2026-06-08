<?php

/**
 * Loads every component, example, and page so their global functions are defined
 * before <App /> renders. Recursive so new files are picked up automatically (no
 * hand-maintained manifest). Runs identically on the server (dist/) and the
 * client (packed WASM FS).
 */

// Compiled JSX emits unqualified `Component::create(...)`. Our component files
// live in the global namespace, so alias the framework class once instead of
// adding a `use` to every file.
if (!class_exists('Component', false)) {
    class_alias(\Syntaxx\PHPX\Framework\Component::class, 'Component');
}

require_once __DIR__ . '/routes.php';

(function () {
    foreach (['components', 'examples', 'pages'] as $dir) {
        $base = __DIR__ . '/' . $dir;
        if (!is_dir($base)) {
            continue;
        }
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
        );
        $files = [];
        foreach ($it as $file) {
            if ($file->isFile() && substr($file->getFilename(), -4) === '.php') {
                $files[] = $file->getPathname();
            }
        }
        sort($files);
        foreach ($files as $f) {
            require_once $f;
        }
    }
})();
