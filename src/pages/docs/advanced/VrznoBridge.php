<?php

function VrznoBridge()
{
    $code = <<<'PHP'
$window = new Vrzno;
$document = $window->document;
$el = $document->getElementById('root');
$el->scrollIntoView(['behavior' => 'smooth']);
$window->console->log('hello from PHP');
PHP;

    return (
        <DocPage title="The VRZNO Bridge" description="Talk to JavaScript and the DOM from PHP.">
            <p>
                VRZNO exposes JavaScript objects as PHP objects. You read properties, call methods, and
                pass values across the boundary with ordinary PHP syntax. This is how PHPX reaches the
                DOM.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="when">When to use it</Heading>
            <p>
                Most of the time you never touch VRZNO directly - the framework handles the DOM for you.
                Reach for it inside effects when you need an imperative browser API such as focus,
                scrolling, or a third-party library.
            </p>

            <Callout type="warning" title="Client only">
                VRZNO exists only in the browser. Never construct it during render or on the server. Use
                it inside effects.
            </Callout>
        </DocPage>
    );
}
