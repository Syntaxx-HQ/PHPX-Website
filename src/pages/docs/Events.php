<?php

function Events()
{
    $click = <<<'PHP'
<button onClick={fn() => doSomething()}>Click</button>
<button onClick={$handler}>Click</button>
PHP;

    $input = <<<'PHP'
<input
    value={$text}
    onInput={fn($e) => $setText($e->target->value)}
    onKeyPress={fn($e) => $e->key === 'Enter' ? $submit() : null}
/>
PHP;

    return (
        <DocPage title="Handling Events" description="Wire up clicks, input, and keyboard events with PHP closures.">
            <p>
                Event handlers are PHP closures passed as <code>on</code>-prefixed props. Pass an
                inline arrow function or a variable holding a closure.
            </p>
            <CodeBlock code={$click} />

            <Heading level={2} id="event-object">The event object</Heading>
            <p>Handlers receive the native event as their first argument. Read input values and key names from it:</p>
            <CodeBlock code={$input} />
            <LiveExample title="A controlled input">
                <TextEchoExample />
            </LiveExample>
            <ul>
                <li><code>{'$e->target->value'}</code> — the value of an input or select</li>
                <li><code>{'$e->key'}</code> — the key name for keyboard events</li>
                <li><code>{'$e->preventDefault()'}</code> — stop the default action</li>
                <li><code>{'$e->stopPropagation()'}</code> — stop the event bubbling</li>
            </ul>

            <Heading level={2} id="delegation">Delegation</Heading>
            <p>
                PHPX attaches a single listener per event type on the root and dispatches by walking up
                from the target. Handlers survive re-renders untouched, which is part of why focus and
                input state are preserved.
            </p>
            <Callout type="note" title="onDoubleClick maps to dblclick">
                Most handlers map to the lowercase event name. The one special case is
                <code>onDoubleClick</code>, which maps to the real <code>dblclick</code> DOM event.
            </Callout>
        </DocPage>
    );
}
