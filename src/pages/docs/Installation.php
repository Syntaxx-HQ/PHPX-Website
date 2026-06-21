<?php

function Installation()
{
    $req = <<<'JSON'
{
    "require": {
        "syntaxx/wasm-php-runtime-vrzno": "8.3.0",
        "syntaxx/phpx-framework": "^0.2.0"
    },
    "require-dev": {
        "syntaxx/phpx-build-tools": "^0.1.0",
        "syntaxx/webassembly-packer": "^0.1.0",
        "syntaxx/phpx-compiler": "^0.1.0"
    }
}
JSON;

    $scripts = <<<'JSON'
"scripts": {
    "build": "phpx-build build",
    "serve": "php -S localhost:9000 -t public"
}
JSON;

    return (
        <DocPage title="Installation" description="Dependencies, build scripts, and the dev server.">
            <Heading level={2} id="deps">Dependencies</Heading>
            <p>A PHPX project depends on the framework and the WASM runtime, plus the build tooling:</p>
            <CodeBlock code={$req} language="json" />

            <Heading level={2} id="scripts">Build scripts</Heading>
            <p>Wire up Composer scripts to build the WASM bundle and serve it:</p>
            <CodeBlock code={$scripts} language="json" />
            <ul>
                <li><code>composer build</code> - compile and pack the WebAssembly bundle.</li>
                <li><code>composer serve</code> - start a local dev server.</li>
            </ul>

            <Callout type="tip" title="Fastest start">
                The starter kits come with everything wired up. Clone one, run
                <code>composer install</code>, <code>composer build</code>, then <code>composer serve</code>.
            </Callout>
        </DocPage>
    );
}
