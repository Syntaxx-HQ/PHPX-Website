<?php

function ConditionalsLists()
{
    $cond = <<<'PHP'
{$loggedIn ? <Dashboard /> : <Login />}
{$error ? <Alert message={$error} /> : null}
PHP;

    $list = <<<'PHP'
<ul>
    {array_map(fn($item) => (
        <li key={$item['id']}>{$item['name']}</li>
    ), $items)}
</ul>
PHP;

    return (
        <DocPage title="Conditionals and Lists" description="Render based on your data.">
            <Heading level={2} id="conditionals">Conditional rendering</Heading>
            <p>Use the ternary operator inside braces. Return <code>null</code> to render nothing.</p>
            <CodeBlock code={$cond} />

            <Heading level={2} id="lists">Lists</Heading>
            <p>
                Map over an array with <code>array_map</code>. Always give list items a stable
                <code>key</code> so the reconciler can match them across renders and preserve their
                state.
            </p>
            <CodeBlock code={$list} />
            <LiveExample title="A growing list">
                <ListExample />
            </LiveExample>

            <Callout type="warning" title="Keys matter">
                Without keys, the reconciler matches items by position. For lists that reorder or change
                length, a stable key avoids subtle bugs where state lands on the wrong row.
            </Callout>
        </DocPage>
    );
}
