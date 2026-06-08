<?php

function StreamingDoc()
{
    $code = <<<'PHP'
use Syntaxx\PHPX\Framework\StreamRenderer;

foreach (StreamRenderer::stream(<App />, $state, $location) as $chunk) {
    echo $chunk['html'] ?? '';
    flush();
}
PHP;

    return (
        <DocPage title="Streaming SSR" description="Flush the shell first, stream the rest.">
            <p>
                Streaming renders the page shell immediately, with each Suspense boundary shown as its
                fallback, and flushes it to the browser right away. As each boundary resolves, its
                content streams in and a tiny inline script reveals it in place.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="chunks">The chunks</Heading>
            <ul>
                <li>A shell chunk with the page and its fallbacks.</li>
                <li>A boundary chunk for each Suspense region as it resolves.</li>
                <li>A closing chunk with the seed state and the runtime loader.</li>
            </ul>

            <Callout type="note" title="Great first paint">
                The user sees meaningful content as soon as the shell arrives, even while slower data is
                still loading. The client then hydrates the completed page.
            </Callout>
        </DocPage>
    );
}
