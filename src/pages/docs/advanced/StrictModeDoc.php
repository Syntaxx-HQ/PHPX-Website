<?php

function StrictModeDoc()
{
    $code = <<<'PHP'
$root->render(
    Component::create('StrictMode', [], [
        Component::create('App', [], []),
    ])
);
PHP;

    return (
        <DocPage title="StrictMode" description="A development wrapper.">
            <p>
                <code>StrictMode</code> is a wrapper component that renders its children unchanged. It is
                a place to add development-time checks without affecting your output.
            </p>
            <CodeBlock code={$code} />
            <Callout type="note" title="No visual effect">
                StrictMode renders nothing of its own. Wrapping your app in it is safe and has no effect
                on the final markup.
            </Callout>
        </DocPage>
    );
}
