<?php

function Hydration()
{
    $client = <<<'PHP'
use Syntaxx\PHPX\Framework\Runtime;

$root = (new Vrzno)->document->getElementById('root');
Runtime::hydrateRoot($root)->render(<App />);
PHP;

    return (
        <DocPage title="Hydration" description="Adopt the server DOM instead of rebuilding it.">
            <p>
                On a server-rendered page the markup already exists. Hydration walks that existing DOM
                and adopts it node by node, attaching handlers and wiring up state without recreating
                anything. There is no flash and no second render.
            </p>
            <CodeBlock code={$client} />

            <Heading level={2} id="state">Seeded state</Heading>
            <p>
                The server embeds a JSON blob of the initial state. On the client, <code>hydrateRoot</code>
                reads and seeds it, so a <code>useState</code> call with a hydration key starts from the
                server value. Data fetched on the server is reused, not fetched again.
            </p>

            <Heading level={2} id="self-heal">Self-healing</Heading>
            <p>
                If the markup ever diverges from what the client expects, PHPX repairs just that subtree
                rather than discarding the whole page. In practice it does not diverge, because both
                sides run the same compiled code.
            </p>

            <Callout type="tip" title="See it for yourself">
                Every live example on this site is server-rendered, then hydrated. View source to see
                the real HTML and the seed blob.
            </Callout>
        </DocPage>
    );
}
