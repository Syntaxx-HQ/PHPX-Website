<?php

function Reconciliation()
{
    $code = <<<'PHP'
<ul>
    {array_map(fn($row) => (
        <li key={$row['id']}>{$row['label']}</li>
    ), $rows)}
</ul>
PHP;

    return (
        <DocPage title="Reconciliation and Keys" description="How PHPX matches elements across renders.">
            <p>
                On each render the reconciler compares the new children against the previous ones.
                Elements match when their type is the same and, for keyed lists, their key is the same.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="keys">Why keys</Heading>
            <p>
                For a list that can reorder, grow, or shrink, a stable key tells the reconciler which
                item is which. Without it, items are matched by position, which can move state to the
                wrong element.
            </p>

            <Heading level={2} id="lifecycle">Mount and unmount</Heading>
            <p>
                When an element appears for the first time its component mounts and its effects run.
                When it disappears its cleanup runs. Keys make these events happen on the right elements.
            </p>
            <LiveExample title="A keyed list">
                <ListExample />
            </LiveExample>
        </DocPage>
    );
}
