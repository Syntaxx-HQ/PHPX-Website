<?php

function EventObject()
{
    $code = <<<'PHP'
<input onInput={fn($e) => $setText($e->target->value)} />
<form onSubmit={fn($e) => { $e->preventDefault(); $save(); }}></form>
<input onKeyDown={fn($e) => $e->key === 'Escape' ? $cancel() : null} />
PHP;

    return (
        <DocPage title="The Event Object" description="Read values and control behavior from the native event.">
            <p>
                Every handler receives the native event object as its first argument. It exposes the
                standard DOM properties and methods through VRZNO.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="members">Common members</Heading>
            <ul>
                <li><code>{'$e->target'}</code> - the element that fired the event.</li>
                <li><code>{'$e->target->value'}</code> - the value of an input or select.</li>
                <li><code>{'$e->key'}</code> - the key name for keyboard events.</li>
                <li><code>{'$e->preventDefault()'}</code> - stop the default action.</li>
                <li><code>{'$e->stopPropagation()'}</code> - stop the event bubbling.</li>
                <li><code>{'$e->target->closest($selector)'}</code> - find an ancestor by selector.</li>
            </ul>
        </DocPage>
    );
}
