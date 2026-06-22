<?php

/**
 * SSR entry. Streams the shell first (Suspense boundaries as fallbacks), then
 * streams each boundary's content; the WASM client hydrates the completed DOM.
 * The same compiled PHP renders here (natively) and in the browser (WASM).
 */

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/dist/App.php';

use Syntaxx\PHPX\Framework\Component;
use Syntaxx\PHPX\Framework\ServerRenderer;
use Syntaxx\PHPX\Framework\StreamRenderer;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$title = function_exists('siteTitle') ? siteTitle($path) : 'PHPX';
$desc = 'PHPX - React-like components written in PHP, compiled to WebAssembly. '
    . 'The same code renders on the server and runs in the browser.';

while (ob_get_level() > 0) {
    ob_end_flush();
}
ob_implicit_flush(true);
header('Content-Type: text/html; charset=utf-8');
header('X-Accel-Buffering: no');

// CodeMirror powers the Playground editor. The editor is built entirely from
// PHPX (src/pages/Playground.php) via VRZNO - no hand-written JS glue. We only
// load the third-party library + a stylesheet here.
$cmHead = <<<'HTML'
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/matchbrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/selection/active-line.min.js"></script>
<style>
.CodeMirror{height:26rem;border:1px solid #e2e8f0;border-radius:.75rem;background:#fff;color:#1e293b;font-family:'JetBrains Mono',ui-monospace,monospace;font-size:14px;line-height:1.6;padding:6px 2px}
.CodeMirror-gutters{background:#fff;border-right:1px solid #f1f5f9}
.CodeMirror-linenumber{color:#cbd5e1}
.CodeMirror-cursor{border-left:1.6px solid #7c3aed}
.CodeMirror-activeline-background{background:rgba(124,58,237,.04)}
.cm-s-default .cm-keyword{color:#7c3aed}
.cm-s-default .cm-def{color:#2563eb}
.cm-s-default .cm-variable,.cm-s-default .cm-variable-2{color:#0f766e}
.cm-s-default .cm-property{color:#2563eb}
.cm-s-default .cm-string,.cm-s-default .cm-string-2{color:#16a34a}
.cm-s-default .cm-number{color:#9333ea}
.cm-s-default .cm-meta{color:#2563eb}
.cm-s-default .cm-tag{color:#2563eb}
.cm-s-default .cm-attribute{color:#16a34a}
.cm-s-default .cm-comment{color:#94a3b8;font-style:italic}
.cm-s-default .cm-operator,.cm-s-default .cm-bracket{color:#475569}
.cm-s-default .CodeMirror-matchingbracket{color:#7c3aed!important;font-weight:600}
</style>
HTML;

$head = "<!doctype html>\n<html lang=\"en\">\n<head>\n"
    . "<meta charset=\"utf-8\">\n"
    . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"
    . '<meta name="description" content="' . htmlspecialchars($desc, ENT_QUOTES) . "\">\n"
    . '<title>' . htmlspecialchars($title, ENT_QUOTES) . "</title>\n"
    . "<script src=\"https://cdn.tailwindcss.com\"></script>\n"
    . "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\n"
    . "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap\">\n"
    . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-light.min.css\">\n"
    . "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js\"></script>\n"
    . "<link rel=\"stylesheet\" href=\"/css/style.css\">\n"
    . $cmHead
    . "</head>\n<body>\n";

$wasmLoader = <<<'JS'
import php from "/build/php-vrzno-web.mjs";
document.addEventListener('DOMContentLoaded', async () => {
    const { ccall } = await php({});
    ccall('phpw_with_args_keepalive', 'string', ['string', 'string', 'string'], ['/app/bootstrap.php']);
    window.php = php;
});
JS;

foreach (StreamRenderer::stream(Component::create('App', [], []), [], ['pathname' => $path, 'search' => '']) as $chunk) {
    if ($chunk['type'] === 'shell') {
        echo $head;
        echo '<div id="root">' . $chunk['html'] . '</div>';
        echo '<script>' . StreamRenderer::revealRuntime() . '</script>' . "\n";
    } elseif ($chunk['type'] === 'boundary') {
        echo '<template data-pxc="' . $chunk['id'] . '">' . $chunk['html'] . '</template>';
        echo '<script>window.__pxReveal("' . $chunk['id'] . '");</script>' . "\n";
    } elseif ($chunk['type'] === 'close') {
        echo ServerRenderer::stateScript($chunk['state']);
        echo '<script type="module">' . $wasmLoader . '</script>' . "\n";
        echo "</body>\n</html>\n";
    }
    flush();
}
