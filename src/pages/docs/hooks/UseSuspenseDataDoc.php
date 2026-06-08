<?php

function UseSuspenseDataDoc()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useSuspenseData;

function Profile() {
    // Returns the data directly, no loading flag.
    $user = useSuspenseData('user', fn() => fetchUser());
    return <div>{$user['name']}</div>;
}
PHP;

    return (
        <DocPage title="useSuspenseData" description="Data fetching that suspends to a boundary.">
            <p>
                <code>useSuspenseData</code> returns the data directly, with no loading flag. While the
                data is in flight it suspends, and the nearest Suspense boundary shows its fallback. On
                the server it fetches synchronously and seeds the value.
            </p>
            <CodeBlock code={$code} />
            <LiveExample title="Suspense in action">
                <SuspenseExample />
            </LiveExample>
            <Callout type="tip" title="Pairs with Suspense">
                Always render a component that calls <code>useSuspenseData</code> inside a
                <a href="/docs/suspense">Suspense</a> boundary.
            </Callout>
        </DocPage>
    );
}
