<?php

function ApiHooks()
{
    $sig = <<<'PHP'
useState($initial, ?string $hydrationKey = null): array   // [$value, $setValue]
useEffect(callable $effect, ?array $deps = null): void
useRef($initial = null): Ref
useMemo(callable $factory, array $deps)
useCallback(callable $callback, array $deps): callable
useData(string $key, callable $fetcher): array            // [$data, $loading, $error]
useSuspenseData(string $key, callable $fetcher)           // returns data or suspends
PHP;

    return (
        <DocPage title="Hooks API" description="Every hook signature at a glance.">
            <p>All hooks are importable from the framework namespace as functions.</p>
            <CodeBlock code={$sig} />
            <Heading level={2} id="server">Server behavior</Heading>
            <ul>
                <li>State, ref, memo, and callback hooks run on both sides.</li>
                <li>Effects run only on the client, never during server rendering.</li>
                <li>Data hooks fetch synchronously on the server and seed the result.</li>
            </ul>
            <p>See the dedicated pages under <a href="/docs/hooks/overview">Hooks</a> for details and live examples.</p>
        </DocPage>
    );
}
