<?php

function DataFetching()
{
    $code = <<<'PHP'
[$user, $loading] = useData('user', function () {
    if (Environment::isServer()) {
        return loadUserFromDatabase();
    }
    return (new Vrzno)->fetch('/api/user')->then(fn($r) => $r->text());
});
PHP;

    return (
        <DocPage title="Isomorphic Data Fetching" description="Fetch on the server, reuse on the client.">
            <p>
                The data hooks let one function describe how to load data on both sides. On the server it
                runs synchronously and the result is seeded into the page. On the client that seed is
                read directly, so the same data is never fetched twice.
            </p>
            <CodeBlock code={$code} />
            <LiveExample title="Server-seeded list">
                <UseDataExample />
            </LiveExample>

            <Heading level={2} id="hooks">Two hooks</Heading>
            <ul>
                <li><a href="/docs/hooks/use-data">useData</a> returns data, a loading flag, and an error.</li>
                <li><a href="/docs/hooks/use-suspense-data">useSuspenseData</a> suspends to a boundary instead.</li>
            </ul>

            <Callout type="tip" title="No double fetch">
                Because the server records what it fetched and the client reads that record, navigating
                to an already-rendered route shows its data instantly.
            </Callout>
        </DocPage>
    );
}
