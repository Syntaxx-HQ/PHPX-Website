<?php

function GettingStarted()
{
    $first = <<<'PHP'
function App() {
    return <h1>Hello, PHPX!</h1>;
}
PHP;

    $rootHtml = <<<'HTML'
<div id="root"></div>
<script type="module" src="/build/php-vrzno-web.mjs"></script>
HTML;

    $mount = <<<'PHP'
use Syntaxx\PHPX\Framework\Runtime;

$root = (new Vrzno)->document->getElementById("root");
Runtime::createRoot($root)->render(<App />);
PHP;

    $counter = <<<'PHP'
use function Syntaxx\PHPX\Framework\useState;

function Counter() {
    [$count, $setCount] = useState(0);
    return (
        <button onClick={fn() => $setCount($count + 1)}>
            Count: {$count}
        </button>
    );
}
PHP;

    return (
        <DocPage title="Getting Started" description="Build and run your first PHPX app in a few minutes.">
            <p>
                PHPX lets you write React-like components in PHP and run them in the browser via
                WebAssembly. You author <code>.phpx</code> files (PHP with JSX), the compiler emits
                plain PHP, and the runtime boots in the browser.
            </p>

            <Heading level={2} id="prerequisites">Prerequisites</Heading>
            <ul>
                <li>PHP 8.4 or higher</li>
                <li>Composer</li>
                <li>A modern browser with WebAssembly support</li>
            </ul>

            <Heading level={2} id="your-first-component">Your first component</Heading>
            <p>A component is a plain PHP function that returns JSX:</p>
            <CodeBlock code={$first} />

            <Heading level={2} id="mounting">Mounting to the page</Heading>
            <p>Your page needs a root element to mount into:</p>
            <CodeBlock code={$rootHtml} language="html" />
            <p>Then mount your root component into it with createRoot:</p>
            <CodeBlock code={$mount} />

            <Heading level={2} id="adding-state">Adding state</Heading>
            <p>
                Use the <code>useState</code> hook to add interactivity. Here is the classic counter -
                and it is <em>actually running</em> below:
            </p>
            <CodeBlock code={$counter} />
            <LiveExample title="A live counter">
                <CounterExample />
            </LiveExample>
            <Callout type="tip" title="It is really running">
                That counter is a real PHPX component compiled to WebAssembly - server-rendered, then
                hydrated. Click it and the state updates with a surgical DOM patch, no full re-render.
            </Callout>

            <Heading level={2} id="next-steps">Next steps</Heading>
            <ul>
                <li><a href="/docs/jsx">JSX Syntax</a> - the rules of JSX-in-PHP.</li>
                <li><a href="/docs/components">Components and Props</a> - composing your UI.</li>
                <li><a href="/docs/hooks/use-state">useState</a> - managing state.</li>
                <li><a href="/docs/ssr/overview">Server-Side Rendering</a> - the isomorphic story.</li>
            </ul>
        </DocPage>
    );
}
