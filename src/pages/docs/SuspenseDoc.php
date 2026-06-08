<?php

function SuspenseDoc()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useSuspenseData;

function Profile() {
    // No loading branch here — it suspends to the boundary.
    $user = useSuspenseData('user', fn() => fetchUser());
    return <div>{$user['name']}</div>;
}

function Page() {
    return (
        <Suspense fallback={<Spinner />}>
            <Profile />
        </Suspense>
    );
}
PHP;

    return (
        <DocPage title="Suspense" description="Declarative loading states with a single fallback.">
            <p>
                A <code>Suspense</code> boundary shows a fallback while a descendant waits on data. The
                component that needs the data carries no loading state of its own.
            </p>
            <CodeBlock code={$code} />
            <LiveExample title="A live Suspense boundary">
                <SuspenseExample />
            </LiveExample>

            <Heading level={2} id="how">How it works</Heading>
            <p>
                <code>useSuspenseData</code> throws a special signal while its data is in flight. The
                nearest boundary catches it, renders the fallback, then re-renders the children once
                the data resolves.
            </p>
            <Callout type="note" title="Works with streaming">
                During streaming SSR, each boundary streams independently — the shell flushes
                immediately, and each boundary content reveals as soon as it resolves.
            </Callout>
        </DocPage>
    );
}
