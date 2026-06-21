<?php

function HowItWorks()
{
    $pipeline = <<<'TXT'
.phpx / .php  ->  PHPX Compiler  ->  plain .php  ->  PHP-WASM  ->  .wasm + .mjs
TXT;

    return (
        <DocPage title="How It Works" description="From JSX-in-PHP to a running WebAssembly app.">
            <p>PHPX has a small, understandable pipeline.</p>
            <CodeBlock code={$pipeline} language="text" />

            <Heading level={2} id="compile">1. Compile</Heading>
            <p>
                The compiler parses your JSX-in-PHP and rewrites each element into a
                <code>Component::create</code> call. The output is ordinary PHP - no magic at runtime.
            </p>

            <Heading level={2} id="pack">2. Pack</Heading>
            <p>
                The build tools bundle your compiled components, the framework, and a PHP filesystem
                image into a WebAssembly data file, alongside the PHP-WASM runtime.
            </p>

            <Heading level={2} id="boot">3. Boot and render</Heading>
            <p>
                The browser loads the runtime, mounts the virtual filesystem, and runs your bootstrap
                file. Your root component renders through the reconciler into the real DOM.
            </p>

            <Heading level={2} id="bridge">DOM access</Heading>
            <p>
                DOM access from PHP goes through VRZNO, a bridge that exposes JavaScript objects as PHP
                objects. You can write <code>{'$window->document->getElementById("root")'}</code>
                directly. See <a href="/docs/advanced/vrzno-bridge">The VRZNO Bridge</a>.
            </p>
        </DocPage>
    );
}
