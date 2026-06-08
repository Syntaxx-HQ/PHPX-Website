<?php

function ApiBuiltins()
{
    $sig = <<<'PHP'
<Suspense fallback={...}>...</Suspense>   // loading boundary
<>...</>                                  // fragment (children flatten in place)
<StrictMode>...</StrictMode>              // development wrapper
PHP;

    return (
        <DocPage title="Built-in Components" description="Components the framework provides.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="suspense">Suspense</Heading>
            <p>Renders its fallback while a descendant suspends on data. See <a href="/docs/suspense">Suspense</a>.</p>
            <Heading level={2} id="fragment">Fragments</Heading>
            <p>Group children without adding a wrapper element. Arrays of children flatten in place.</p>
            <Heading level={2} id="strict">StrictMode</Heading>
            <p>A passthrough wrapper for development checks. See <a href="/docs/advanced/strict-mode">StrictMode</a>.</p>
        </DocPage>
    );
}
