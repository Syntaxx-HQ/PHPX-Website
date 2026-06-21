<?php

function UseEffectDoc()
{
    $basic = <<<'PHP'
use function Syntaxx\PHPX\Framework\useEffect;

useEffect(function () {
    // runs after render
    $window = new Vrzno();
    $window->document->title = "Count: $count";
}, [$count]); // re-runs only when $count changes
PHP;

    $cleanup = <<<'PHP'
useEffect(function () {
    $window = new Vrzno();
    $id = $window->setInterval(fn() => tick(), 1000);
    return fn() => $window->clearInterval($id); // cleanup
}, []); // [] = run once on mount
PHP;

    return (
        <DocPage title="useEffect" description="Run side effects after the DOM is updated.">
            <p>
                <code>useEffect</code> runs a function after the component commits. Use it for
                anything outside pure rendering - timers, subscriptions, imperative DOM work, or
                syncing with the outside world.
            </p>
            <CodeBlock code={$basic} />

            <Heading level={2} id="dependencies">Dependencies</Heading>
            <p>The second argument controls when the effect re-runs:</p>
            <ul>
                <li><code>[$a, $b]</code> - re-run whenever a listed value changes</li>
                <li><code>[]</code> - run once, after the first render</li>
                <li>omitted (null) - run after every render</li>
            </ul>

            <Heading level={2} id="cleanup">Cleanup</Heading>
            <p>Return a function to clean up before the effect re-runs and when the component unmounts:</p>
            <CodeBlock code={$cleanup} />
            <LiveExample title="A timer with cleanup">
                <TimerExample />
            </LiveExample>

            <Callout type="warning" title="Effects never run on the server">
                During SSR, effects are skipped - they only run after the client takes over. That makes
                effects the right place for browser-only work like DOM access via VRZNO.
            </Callout>
        </DocPage>
    );
}
