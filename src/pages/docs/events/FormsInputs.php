<?php

function FormsInputs()
{
    $code = <<<'PHP'
function NameField() {
    [$name, $setName] = useState('');
    return (
        <input
            value={$name}
            onInput={fn($e) => $setName($e->target->value)}
        />
    );
}
PHP;

    return (
        <DocPage title="Forms and Controlled Inputs" description="Inputs that keep their focus and caret.">
            <p>
                A controlled input takes its value from state and updates that state on every change. In
                many runtimes this loses focus on each keystroke. In PHPX the reconciler patches only
                the changed attribute, so focus and caret stay exactly where they were.
            </p>
            <CodeBlock code={$code} />
            <LiveExample title="Type and watch focus stay put">
                <TextEchoExample />
            </LiveExample>

            <Heading level={2} id="keyboard">Keyboard handling</Heading>
            <p>Use <code>onKeyPress</code> or <code>onKeyDown</code> to react to keys - for example, submit on Enter.</p>
            <LiveExample title="Press Enter to add">
                <TodoExample />
            </LiveExample>

            <Callout type="tip" title="onInput versus onChange">
                <code>onInput</code> fires on every keystroke, which is what you usually want for live
                binding. <code>onChange</code> fires on commit, which suits selects and checkboxes.
            </Callout>
        </DocPage>
    );
}
