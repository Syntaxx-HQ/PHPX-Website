<?php

function UseStateDoc()
{
    $basic = <<<'PHP'
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

    $functional = <<<'PHP'
// Pass a function when the next value depends on the previous one:
$setCount(fn($prev) => $prev + 1);
PHP;

    $lazy = <<<'PHP'
// Pass a function as the initial value to compute it once (lazy init):
[$rows, $setRows] = useState(fn() => expensiveInitialRows());
PHP;

    return (
        <DocPage title="useState" description="Add local, reactive state to a component.">
            <p>
                <code>useState</code> returns a two-element array: the current value and a setter.
                Calling the setter schedules a re-render with the new value.
            </p>
            <CodeBlock code={$basic} />
            <LiveExample title="Live counter">
                <CounterExample />
            </LiveExample>

            <Heading level={2} id="functional-updates">Functional updates</Heading>
            <p>When the new state depends on the old state, pass a function to the setter:</p>
            <CodeBlock code={$functional} />

            <Heading level={2} id="lazy">Lazy initial state</Heading>
            <p>If computing the initial value is expensive, pass a function — it runs only once:</p>
            <CodeBlock code={$lazy} />

            <Heading level={2} id="bail-out">Bail-out</Heading>
            <p>
                If you set the state to a value that is strictly identical to the current one, PHPX
                skips the re-render. State is per-instance, so two counters never share a value.
            </p>
            <LiveExample title="Two independent counters">
                <TwoCountersExample />
            </LiveExample>

            <Heading level={2} id="signature">Signature</Heading>
            <PropsTable rows={[
                ['initialValue', 'mixed', 'required', 'Initial state, or a function computing it once'],
                ['hydrationKey', '?string', 'null', 'Seeds the value from server-rendered state during hydration'],
            ]} />
        </DocPage>
    );
}
