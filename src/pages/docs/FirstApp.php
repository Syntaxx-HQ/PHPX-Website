<?php

function FirstApp()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useState;

function Counter() {
    [$count, $setCount] = useState(0);
    return (
        <div>
            <p>You clicked {$count} times</p>
            <button onClick={fn() => $setCount($count + 1)}>Click me</button>
        </div>
    );
}
PHP;

    return (
        <DocPage title="Your First App" description="Build an interactive counter end to end.">
            <p>
                Let us build the classic counter. It uses one piece of state and one event handler - the
                two building blocks of every interactive component.
            </p>
            <CodeBlock code={$code} />
            <p>And here it is, running live:</p>
            <LiveExample title="Your counter">
                <CounterExample />
            </LiveExample>

            <Heading level={2} id="whats-happening">What is happening</Heading>
            <ul>
                <li><code>useState(0)</code> creates a state value starting at zero and a setter.</li>
                <li>The <code>onClick</code> handler calls the setter, which schedules a re-render.</li>
                <li>The reconciler updates only the text node that changed - nothing else moves.</li>
            </ul>

            <Callout type="tip" title="Keep going">
                Add a second button that resets the count, or a third that decrements. Each is one more
                handler. Then read <a href="/docs/hooks/use-state">useState</a> for the full story.
            </Callout>
        </DocPage>
    );
}
