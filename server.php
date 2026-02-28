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
$desc = 'PHPX — React-like components written in PHP, compiled to WebAssembly. '
    . 'The same code renders on the server and runs in the browser.';

while (ob_get_level() > 0) {
    ob_end_flush();
}
ob_implicit_flush(true);
header('Content-Type: text/html; charset=utf-8');
header('X-Accel-Buffering: no');

// CodeMirror powers the Playground editor. A small native-JS helper builds the
// editor (constructing the options object in JS sidesteps VRZNO marshalling).
$cmHead = <<<'HTML'
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/dracula.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
<style>.CodeMirror{height:24rem;border-radius:.5rem;font-size:13px;line-height:1.5}</style>
<script>
window.initPgEditor = function (id) {
  if (!window.CodeMirror || window.__pgEditor) return;
  var ta = document.getElementById(id);
  if (!ta) return;
  window.__pgEditor = CodeMirror.fromTextArea(ta, {
    lineNumbers: true,
    mode: { name: 'php', startOpen: true },
    theme: 'dracula',
    tabSize: 4, indentUnit: 4, lineWrapping: true
  });
};
window.getPgCode = function () {
  if (window.__pgEditor) return window.__pgEditor.getValue();
  var ta = document.getElementById('playground-code');
  return ta ? ta.value : '';
};
window.setPgCode = function (code) {
  if (window.__pgEditor) window.__pgEditor.setValue(code);
  else { var ta = document.getElementById('playground-code'); if (ta) ta.value = code; }
};
</script>
HTML;

$head = "<!doctype html>\n<html lang=\"en\">\n<head>\n"
    . "<meta charset=\"utf-8\">\n"
    . "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"
    . '<meta name="description" content="' . htmlspecialchars($desc, ENT_QUOTES) . "\">\n"
    . '<title>' . htmlspecialchars($title, ENT_QUOTES) . "</title>\n"
    . "<script src=\"https://cdn.tailwindcss.com\"></script>\n"
    . "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\n"
    . "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap\">\n"
    . "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css\">\n"
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
