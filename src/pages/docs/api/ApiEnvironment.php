<?php

function ApiEnvironment()
{
    $sig = <<<'PHP'
Environment::isServer(): bool
Environment::location(): array  // ['pathname' => ..., 'search' => ..., 'href' => ...]
Environment::withServer(?array $location, callable $fn)
PHP;

    return (
        <DocPage title="Environment" description="Tell server from client, read the location.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="is-server">isServer</Heading>
            <p>Returns true during server rendering. Use it to guard server-only or client-only branches.</p>
            <Heading level={2} id="location">location</Heading>
            <p>Returns the current location on both sides. On the client it reflects the URL, on the server the request path. When the router is active, it reads from the router.</p>
        </DocPage>
    );
}
