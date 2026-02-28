<?php

function ApiComponentResolver()
{
    $sig = <<<'PHP'
ComponentResolver::register(string $name, callable $component): void
ComponentResolver::resolve(string $type): ?callable
ComponentResolver::isHtmlElement(string $type): bool
PHP;

    return (
        <DocPage title="ComponentResolver" description="How names become components.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="order">Resolution order</Heading>
            <p>A capitalized name resolves in this order: an explicitly registered component, then the demo namespace, then a global function. Lowercase names are always host elements.</p>
            <Heading level={2} id="register">register</Heading>
            <p>Registers a component under a name, which takes precedence over the other lookups.</p>
        </DocPage>
    );
}
