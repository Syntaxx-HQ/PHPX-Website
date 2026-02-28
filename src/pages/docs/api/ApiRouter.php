<?php

function ApiRouter()
{
    $sig = <<<'PHP'
Router::start(callable $onChange): void
Router::navigate(string $href): void
Router::current(): array        // ['pathname' => string, 'search' => string]
Router::isActive(): bool
PHP;

    return (
        <DocPage title="Router" description="Client-side navigation API.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="start">start</Heading>
            <p>Begins intercepting internal links and history changes. The callback runs after each navigation and should re-render the app root.</p>
            <Heading level={2} id="navigate">navigate</Heading>
            <p>Navigates to an internal path in code, pushing a history entry and re-rendering.</p>
        </DocPage>
    );
}
