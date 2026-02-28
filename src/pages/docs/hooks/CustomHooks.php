<?php

function CustomHooks()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useState;

function useToggle($initial = false) {
    [$on, $setOn] = useState($initial);
    $toggle = fn() => $setOn(fn($v) => !$v);
    return [$on, $toggle];
}

// Use it like any built-in hook:
[$open, $toggleOpen] = useToggle();
PHP;

    return (
        <DocPage title="Custom Hooks" description="Extract and reuse stateful logic.">
            <p>
                A custom hook is just a function that calls other hooks. By convention its name starts
                with <code>use</code>. It lets you share stateful logic between components without
                sharing state.
            </p>
            <CodeBlock code={$code} />
            <Callout type="note" title="The rules still apply">
                Custom hooks must follow the rules of hooks: call them at the top level of a component
                or another hook, never conditionally.
            </Callout>
        </DocPage>
    );
}
