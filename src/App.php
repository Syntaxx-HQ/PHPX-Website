<?php

use Syntaxx\PHPX\Framework\Component;
use Syntaxx\PHPX\Framework\Environment;

require_once __DIR__ . '/includes.php';

/**
 * Root component. Resolves the current location to a page component and wraps it
 * in the marketing layout (SiteLayout) or the docs layout (DocsLayout). Runs the
 * same on the server (SSR) and the client (after hydration / on navigation).
 */
function App()
{
    $path = Environment::location()['pathname'] ?? '/';
    [$component, $isDocs] = routeComponent($path);
    $page = Component::create($component, [], []);
    $layout = $isDocs ? 'DocsLayout' : 'SiteLayout';
    return Component::create($layout, ['path' => $path], [$page]);
}

/** Placeholder for routes whose page isn't written yet. */
function ComingSoon()
{
    return (
        <div className="prose">
            <h1>Coming soon</h1>
            <p className="lead">This page is being written. Check back shortly.</p>
            <p><a href="/docs/getting-started">Back to Getting Started</a></p>
        </div>
    );
}

function NotFound()
{
    return (
        <div className="prose" data-testid="not-found">
            <h1>404 - Not found</h1>
            <p className="lead">That page does not exist.</p>
            <p><a href="/">Back home</a></p>
        </div>
    );
}
