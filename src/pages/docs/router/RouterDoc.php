<?php

function RouterDoc()
{
    $start = <<<'PHP'
use Syntaxx\PHPX\Framework\Router;

$app = Runtime::hydrateRoot($root);
$app->render(<App />);

// Re-render in place whenever the URL changes:
Router::start(function () use ($app) {
    $app->render(<App />);
});
PHP;

    $loc = <<<'PHP'
use Syntaxx\PHPX\Framework\Environment;

function App() {
    $path = Environment::location()['pathname'];
    return $path === '/about' ? <About /> : <Home />;
}
PHP;

    return (
        <DocPage title="Client Router" description="SPA navigation without re-booting the runtime.">
            <p>
                After hydration, the router intercepts internal link clicks and back/forward
                navigation. It updates the URL with the History API and re-renders in place - no full
                page reload, and no WebAssembly reboot.
            </p>
            <CodeBlock code={$start} />

            <Heading level={2} id="location">Reading the location</Heading>
            <p>
                Components read the current path with <code>{'Environment::location()'}</code>, which
                works the same on the server and the client. Switch on it to render the right page.
            </p>
            <CodeBlock code={$loc} />

            <Heading level={2} id="links">Links</Heading>
            <p>
                Use plain anchor tags. The router intercepts internal links automatically and leaves
                external links, new-tab clicks, and modified clicks alone.
            </p>
            <Callout type="tip" title="You are using it right now">
                The sidebar on this page navigates with the client router. Click around and watch the
                URL change without a reload.
            </Callout>
        </DocPage>
    );
}
