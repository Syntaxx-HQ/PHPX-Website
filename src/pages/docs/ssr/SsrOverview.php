<?php

function SsrOverview()
{
    $server = <<<'PHP'
use Syntaxx\PHPX\Framework\ServerRenderer;

$result = ServerRenderer::render(
    Component::create('App', [], []),
    ['count' => 3],
    ['pathname' => '/', 'search' => '']
);

echo $result['html'];
echo ServerRenderer::stateScript($result['state']);
PHP;

    $client = <<<'PHP'
use Syntaxx\PHPX\Framework\Runtime;

$root = (new Vrzno)->document->getElementById('root');
Runtime::hydrateRoot($root)->render(<App />);
PHP;

    return (
        <DocPage title="Server-Side Rendering" description="Render real HTML on the server, then hydrate it in the browser.">
            <p>
                PHPX is isomorphic by construction. The same compiled component code runs natively on
                the server to produce HTML, and as WebAssembly in the browser to make it interactive.
            </p>

            <Heading level={2} id="server">On the server</Heading>
            <p><code>ServerRenderer::render</code> returns the HTML and the seed state. Embed both in your page.</p>
            <CodeBlock code={$server} />

            <Heading level={2} id="client">On the client</Heading>
            <p><code>hydrateRoot</code> adopts the server DOM in place instead of rebuilding it — no flash, no refetch.</p>
            <CodeBlock code={$client} />
            <LiveExample title="This data was server-rendered">
                <UseDataExample />
            </LiveExample>

            <Callout type="tip" title="No hydration mismatches">
                Because both sides run the same compiled PHP and seed from the same state, the markup
                always matches. The whole class of React hydration-mismatch bugs simply does not occur.
            </Callout>

            <Heading level={2} id="more">Going further</Heading>
            <ul>
                <li><a href="/docs/ssr/hydration">Hydration</a> — how adoption works.</li>
                <li><a href="/docs/ssr/streaming">Streaming</a> — flush the shell first.</li>
                <li><a href="/docs/suspense">Suspense</a> — declarative loading boundaries.</li>
            </ul>
        </DocPage>
    );
}
