<?php

function UseMemoDoc()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useMemo;

$sorted = useMemo(fn() => expensiveSort($items), [$items]);
PHP;

    return (
        <DocPage title="useMemo" description="Cache an expensive computation.">
            <p>
                <code>useMemo</code> runs a factory function and caches the result. It recomputes only
                when one of the dependencies changes.
            </p>
            <CodeBlock code={$code} />
            <Callout type="note" title="Use it when it pays">
                Memoization has a cost of its own. Reach for <code>useMemo</code> when a computation is
                genuinely expensive, or when you need a stable reference to pass to a child.
            </Callout>
            <PropsTable rows={[
                ['factory', 'callable', 'required', 'Returns the value to memoize'],
                ['deps', 'array', 'required', 'Recompute when any listed value changes'],
            ]} />
        </DocPage>
    );
}
