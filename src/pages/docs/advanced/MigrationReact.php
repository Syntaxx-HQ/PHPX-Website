<?php

function MigrationReact()
{
    $code = <<<'TXT'
React                            PHPX
---------------------------      ---------------------------
() => setCount(count + 1)        fn() => $setCount($count + 1)
{ color: 'red' }                 ['color' => 'red']
{count}                          {$count}
const [c, setC] = useState(0)    [$c, $setC] = useState(0)
TXT;

    return (
        <DocPage title="Coming from React" description="A quick translation guide.">
            <p>
                If you know React, the jump is mostly syntax. The concepts map one to one: components,
                props, children, hooks, and JSX.
            </p>
            <CodeBlock code={$code} language="text" />

            <Heading level={2} id="same">What is the same</Heading>
            <ul>
                <li>useState, useEffect, useRef, useMemo, and useCallback behave as you expect.</li>
                <li>Components are functions that return markup.</li>
                <li>Lists need keys, and effects need dependency arrays.</li>
            </ul>

            <Heading level={2} id="different">What is different</Heading>
            <ul>
                <li>Write PHP inside braces: fn not arrow, arrays not objects, dollar-prefixed variables.</li>
                <li>There is no separate JavaScript build step — PHP compiles to WebAssembly.</li>
                <li>SSR is isomorphic by default, so hydration mismatches do not happen.</li>
            </ul>
        </DocPage>
    );
}
