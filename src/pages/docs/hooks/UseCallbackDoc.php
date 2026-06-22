<?php

function UseCallbackDoc()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useCallback;

$handleSave = useCallback(fn() => save($id), [$id]);
PHP;

    return (
        <DocPage title="useCallback" description="A stable function identity across renders.">
            <p>
                <code>useCallback</code> returns the same function instance until its dependencies
                change. It is <code>useMemo</code> specialized for callbacks - useful for passing a
                stable handler to a child component.
            </p>
            <CodeBlock code={$code} />
            <PropsTable rows={[
                ['callback', 'callable', 'required', 'The function to memoize'],
                ['deps', 'array', 'required', 'Return a new function when any value changes'],
            ]} />
        </DocPage>
    );
}
