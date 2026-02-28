<?php

function EnvironmentDoc()
{
    $code = <<<'PHP'
use Syntaxx\PHPX\Framework\Environment;

function Widget() {
    if (Environment::isServer()) {
        // server-only branch
    }
    $path = Environment::location()['pathname'];
    return <div>You are at {$path}</div>;
}
PHP;

    return (
        <DocPage title="Isomorphic Components" description="Write components that run on both sides.">
            <p>
                The same component runs on the server and the client. Most code is identical on both
                sides. For the few places that differ, the <code>Environment</code> helper tells you
                where you are.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="golden-rule">The golden rule</Heading>
            <p>
                Never touch the browser or VRZNO directly during render — the server has no DOM. Put DOM
                access inside effects, which run only on the client, and read the URL with
                <code>{'Environment::location()'}</code> on either side.
            </p>
            <ul>
                <li><code>{'Environment::isServer()'}</code> — true during server rendering.</li>
                <li><code>{'Environment::location()'}</code> — the current path and query, on both sides.</li>
            </ul>
        </DocPage>
    );
}
