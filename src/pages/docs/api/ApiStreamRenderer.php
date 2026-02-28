<?php

function ApiStreamRenderer()
{
    $sig = <<<'PHP'
StreamRenderer::stream($component, array $state = [], ?array $location = null): Generator
    // yields ['type' => 'shell',    'html'  => string]
    //        ['type' => 'boundary', 'id'    => int, 'html' => string]
    //        ['type' => 'close',    'state' => array]

StreamRenderer::revealRuntime(): string
PHP;

    return (
        <DocPage title="StreamRenderer" description="Stream a page shell, then its Suspense boundaries.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="stream">stream</Heading>
            <p>Returns a generator. Echo each chunk and flush so the browser receives the shell first and the boundaries as they resolve.</p>
            <Heading level={2} id="reveal">revealRuntime</Heading>
            <p>Returns the small inline script that swaps each streamed boundary into its placeholder.</p>
        </DocPage>
    );
}
