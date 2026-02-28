<?php

function JsxSyntax()
{
    $elements = <<<'PHP'
<div className="card">
    <h1>{$title}</h1>
    <p>Hello, {$name}</p>
    <input type="text" />
</div>
PHP;

    $php = <<<'PHP'
// Correct — PHP inside the braces:
<button onClick={fn() => $setCount($count + 1)}>+1</button>
<div className={$active ? 'on' : 'off'}>...</div>

// Wrong — JavaScript syntax does not parse:
<button onClick={() => setCount(count + 1)}>+1</button>
<div className={{ active: true }}>...</div>
PHP;

    $compiles = <<<'PHP'
// This element:
<div className="x">{$y}</div>

// compiles to this plain PHP:
Component::create("div", ["className" => "x"], [$y])
PHP;

    $cond = <<<'PHP'
<div>
    {$loggedIn ? <span>Welcome</span> : <a href="/login">Log in</a>}
    {$count > 0 ? <Badge count={$count} /> : null}
</div>
PHP;

    $list = <<<'PHP'
<ul>
    {array_map(fn($item) => <li key={$item['id']}>{$item['name']}</li>, $items)}
</ul>
PHP;

    return (
        <DocPage title="JSX Syntax" description="Write HTML-like markup directly in PHP.">
            <p>
                PHPX lets you write markup inside PHP. Tags become elements or components, and curly
                braces hold PHP expressions. Use camelCase prop names such as className, and close
                self-closing tags with a slash.
            </p>
            <CodeBlock code={$elements} />

            <Heading level={2} id="expressions">Expressions are PHP</Heading>
            <Callout type="warning" title="Everything inside curly braces must be valid PHP">
                Use <code>fn()</code> for arrow functions, PHP arrays for props, and prefix variables
                with a dollar sign. JavaScript syntax will not parse.
            </Callout>
            <CodeBlock code={$php} />

            <Heading level={2} id="compiles">How it compiles</Heading>
            <p>Every element compiles to a <code>Component::create</code> call — type, props, children:</p>
            <CodeBlock code={$compiles} />

            <Heading level={2} id="conditionals">Conditional rendering</Heading>
            <p>Use the ternary operator. Return <code>null</code> to render nothing.</p>
            <CodeBlock code={$cond} />

            <Heading level={2} id="lists">Rendering lists</Heading>
            <p>Map over an array with <code>array_map</code>. Give items a <code>key</code> prop so the reconciler can match them across renders.</p>
            <CodeBlock code={$list} />
            <LiveExample title="A list you can grow">
                <ListExample />
            </LiveExample>

            <Callout type="note" title="Watch out for these">
                Reserved words cannot be component names, and dynamic or namespaced names are not
                supported. See <a href="/docs/gotchas">PHPX Gotchas</a> for the full list.
            </Callout>
        </DocPage>
    );
}
