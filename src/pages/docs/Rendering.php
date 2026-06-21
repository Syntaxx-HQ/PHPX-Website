<?php

function Rendering()
{
    $mount = <<<'PHP'
use Syntaxx\PHPX\Framework\Runtime;

$root = (new Vrzno)->document->getElementById('root');
Runtime::createRoot($root)->render(<App />);
PHP;

    $create = <<<'PHP'
// JSX and the manual form are equivalent:
<div className="box">{$child}</div>
Component::create('div', ['className' => 'box'], [$child]);
PHP;

    return (
        <DocPage title="Rendering and Mounting" description="Get your component tree onto the page.">
            <Heading level={2} id="create-root">createRoot</Heading>
            <p>
                <code>{'Runtime::createRoot($element)'}</code> takes a DOM element and returns a root.
                Calling <code>render</code> mounts your tree into it. The first render clears the
                element, and later renders patch it.
            </p>
            <CodeBlock code={$mount} />

            <Heading level={2} id="component-create">Component::create</Heading>
            <p>JSX is sugar over <code>Component::create</code>, which takes a type, a props array, and a children array:</p>
            <CodeBlock code={$create} />

            <Heading level={2} id="register">Registering components</Heading>
            <p>
                Names normally resolve to global functions. To register a component explicitly - for
                example a closure - use <code>{'Runtime::registerComponent($name, $callable)'}</code>.
            </p>

            <Callout type="note" title="Hydration is different">
                On a server-rendered page you call <code>hydrateRoot</code> instead of
                <code>createRoot</code>, so the existing DOM is adopted rather than rebuilt. See
                <a href="/docs/ssr/hydration">Hydration</a>.
            </Callout>
        </DocPage>
    );
}
