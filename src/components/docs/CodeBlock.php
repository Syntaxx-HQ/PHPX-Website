<?php

use function Syntaxx\PHPX\Framework\useRef;
use function Syntaxx\PHPX\Framework\useEffect;

/**
 * Syntax-highlighted code block. Highlighting runs in an effect (client only —
 * effects never run on the server), keyed to the code, and clears hljs's
 * data-highlighted marker first so it re-highlights after surgical re-patches.
 * On the server the code renders as plain text (progressive enhancement).
 */
function CodeBlock($props)
{
    $code = $props['code'] ?? '';
    $language = $props['language'] ?? 'php';
    $ref = useRef(null);

    useEffect(function () use ($ref) {
        $el = $ref->current;
        if (!$el) {
            return;
        }
        $window = new Vrzno();
        if ($window->hljs) {
            $el->removeAttribute('data-highlighted');
            $window->hljs->highlightElement($el);
        }
    }, [$code]);

    return (
        <pre className="rounded-lg overflow-x-auto bg-slate-900 text-slate-100 p-4 text-sm leading-relaxed my-5">
            <code ref={$ref} className={"language-" . $language}>{$code}</code>
        </pre>
    );
}
