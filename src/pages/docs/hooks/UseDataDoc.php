<?php

function UseDataDoc()
{
    $basic = <<<'PHP'
use function Syntaxx\PHPX\Framework\useData;
use Syntaxx\PHPX\Framework\Environment;

[$todos, $loading, $error] = useData('todos', function () {
    if (Environment::isServer()) {
        return fetchTodosFromDatabase();
    }
    return (new Vrzno)->fetch('/api/todos')->then(fn($r) => $r->text());
});
PHP;

    return (
        <DocPage title="useData" description="Isomorphic data fetching — fetch once on the server, read on the client.">
            <p>
                <code>useData</code> returns the data, a loading flag, and an error. On the server it
                runs the fetcher synchronously and seeds the value into the page. On the client it
                reads that seed without refetching, or fetches on demand for routes the server never
                rendered.
            </p>
            <CodeBlock code={$basic} />
            <LiveExample title="Server-seeded data">
                <UseDataExample />
            </LiveExample>

            <Heading level={2} id="behavior">Behavior</Heading>
            <ul>
                <li>Server — runs the fetcher, records the value, returns it with loading false.</li>
                <li>Client, seeded — returns the seed immediately, no refetch.</li>
                <li>Client, not seeded — returns loading, fetches in an effect, then re-renders.</li>
            </ul>
            <Callout type="tip" title="One source of truth">
                Because the same function runs on both sides, the server and client always agree on the
                data shape. No hydration mismatch.
            </Callout>
        </DocPage>
    );
}
