<?php

function ApiComponent()
{
    $sig = <<<'PHP'
Component::create(string $type, array $props = [], array $children = []): Component
PHP;

    return (
        <DocPage title="Component" description="The element factory.">
            <CodeBlock code={$sig} />
            <p>
                <code>Component::create</code> is what JSX compiles to. The type is an HTML tag, a
                component name, or a built-in such as Suspense.
            </p>
            <Heading level={2} id="reserved">Reserved props</Heading>
            <ul>
                <li><code>key</code> - stable identity for reconciliation. Not passed to the component.</li>
                <li><code>ref</code> - binds a useRef to a host node.</li>
                <li><code>children</code> - the nested content, available as a prop.</li>
            </ul>
        </DocPage>
    );
}
