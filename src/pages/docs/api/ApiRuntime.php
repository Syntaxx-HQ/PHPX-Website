<?php

function ApiRuntime()
{
    $sig = <<<'PHP'
Runtime::createRoot($element): Root
Runtime::hydrateRoot($element): Root
Runtime::registerComponent(string $name, callable $component): void

$root->render($element): void
PHP;

    return (
        <DocPage title="Runtime" description="Mount and update component trees.">
            <CodeBlock code={$sig} />
            <Heading level={2} id="create-root">createRoot</Heading>
            <p>Creates a root that owns an element. The first render clears the element, and later renders patch it.</p>
            <Heading level={2} id="hydrate-root">hydrateRoot</Heading>
            <p>Like createRoot, but adopts existing server-rendered markup instead of clearing it, and reads the seed state from the page.</p>
            <Heading level={2} id="register">registerComponent</Heading>
            <p>Registers a component callable under a name, taking precedence over global function lookup.</p>
        </DocPage>
    );
}
