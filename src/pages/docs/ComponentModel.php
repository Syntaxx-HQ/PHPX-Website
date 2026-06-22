<?php

function ComponentModel()
{
    $define = <<<'PHP'
function Greeting($props) {
    $name = $props['name'] ?? 'world';
    return <h1>Hello, {$name}</h1>;
}

// Use it:
<Greeting name="PHPX" />
PHP;

    $children = <<<'PHP'
function Card($props) {
    return (
        <div className="card">
            {$props['children']}
        </div>
    );
}

<Card>
    <h2>Title</h2>
    <p>Body content</p>
</Card>
PHP;

    $callback = <<<'PHP'
function Parent() {
    [$count, $setCount] = useState(0);
    return (
        <div>
            <p>Clicked {$count} times</p>
            <Child onPress={fn() => $setCount($count + 1)} />
        </div>
    );
}

function Child($props) {
    return <button onClick={$props['onPress']}>Press me</button>;
}
PHP;

    return (
        <DocPage title="Components and Props" description="Components are plain PHP functions that return JSX.">
            <p>
                A component is a global PHP function that receives a <code>$props</code> array and
                returns JSX. Capitalized names resolve to components, while lowercase names are host
                elements like <code>div</code> or <code>button</code>.
            </p>
            <CodeBlock code={$define} />

            <Heading level={2} id="props">Props</Heading>
            <p>
                Everything you pass as an attribute arrives in <code>$props</code>. Read values with
                the null-coalescing operator to provide defaults. The special <code>children</code>
                prop holds whatever you nest inside the tag.
            </p>
            <CodeBlock code={$children} />

            <Heading level={2} id="callbacks">Passing callbacks down</Heading>
            <p>Pass functions as props to let children talk back to their parent:</p>
            <CodeBlock code={$callback} />

            <Heading level={2} id="resolution">How names resolve</Heading>
            <p>When the runtime sees a capitalized tag, it looks for the component in this order:</p>
            <ul>
                <li>A component registered with <code>{'Runtime::registerComponent'}</code></li>
                <li>A function in the <code>{'Syntaxx\\PHPX\\Demo'}</code> namespace</li>
                <li>A global function with that name</li>
            </ul>
            <Callout type="tip" title="Per-instance state">
                Each rendered instance of a component has its own hook state - two
                <code>Counter</code> elements count independently.
            </Callout>
        </DocPage>
    );
}
