<?php

function JsxGotchas()
{
    $php = <<<'PHP'
// Inside braces, write PHP — not JavaScript:
onClick={fn() => $do()}          // not () => do()
className={['a' => true]}         // not {a: true}
{$name}                          // not {name}
PHP;

    $names = <<<'PHP'
// Reserved words cannot be component names:
<List />     // fails - 'list' is reserved
<Switch />   // fails - 'switch' is reserved

// Use a different name instead:
<ItemList />
<Toggle />
PHP;

    return (
        <DocPage title="JSX Gotchas" description="The sharp edges of JSX-in-PHP, and how to avoid them.">
            <Heading level={2} id="php-not-js">Braces hold PHP, not JavaScript</Heading>
            <p>Everything inside curly braces is parsed as PHP. The three most common mistakes:</p>
            <CodeBlock code={$php} />

            <Heading level={2} id="capitalization">Capitalization decides the meaning</Heading>
            <p>
                A capitalized tag is a component lookup, while a lowercase tag is a host element. That means
                <code>Nav</code> and <code>nav</code> are different things, even though one looks like an
                HTML element. A capitalized name that resolves to nothing renders as an empty element.
            </p>

            <Heading level={2} id="reserved">Reserved words and dynamic names</Heading>
            <p>A few naming rules to keep in mind:</p>
            <CodeBlock code={$names} />
            <ul>
                <li>PHP reserved words cannot be component names.</li>
                <li>Dynamic component names like a variable in the tag position are not supported.</li>
                <li>Namespaced tags are not supported, but dot-notation such as <code>Form.Input</code> is.</li>
            </ul>

            <Callout type="warning" title="Authoring tip">
                Inside JSX text, prefer plain words over heavy punctuation. When you need symbols in
                inline code, wrap them in a PHP string expression like
                <code>{'<code>{\'$e->target->value\'}</code>'}</code>.
            </Callout>
        </DocPage>
    );
}
