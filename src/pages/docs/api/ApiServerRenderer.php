<?php

function ApiServerRenderer()
{
    $sig = <<<'PHP'
ServerRenderer::render($component, array $state = [], ?array $location = null): array
    // returns ['html' => string, 'state' => array]

ServerRenderer::renderToString($component, array $state = [], ?array $location = null): string

ServerRenderer::stateScript(array $state): string
PHP;

    return (
        <DocPage title="ServerRenderer" description="Render components to HTML on the server.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="render">render</Heading>
            <p>Renders a component to HTML and returns both the markup and the full seed state, including anything the data hooks fetched.</p>
            <Heading level={2} id="state-script">stateScript</Heading>
            <p>Serializes the seed state into a script tag that the client reads during hydration.</p>
        </DocPage>
    );
}
