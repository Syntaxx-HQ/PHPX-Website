<?php

function UseRefDoc()
{
    $code = <<<'PHP'
use function Syntaxx\PHPX\Framework\useRef;
use function Syntaxx\PHPX\Framework\useEffect;

function TextField() {
    $inputRef = useRef(null);
    useEffect(function () use ($inputRef) {
        $inputRef->current->focus();
    }, []);
    return <input ref={$inputRef} />;
}
PHP;

    return (
        <DocPage title="useRef" description="A mutable value that survives re-renders.">
            <p>
                <code>useRef</code> returns an object with a <code>current</code> property. Writing to
                <code>current</code> does not trigger a render, and the value persists across renders.
                The most common use is holding a DOM node.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="dom">Referencing a DOM node</Heading>
            <p>
                Pass a ref to a host element with the <code>ref</code> prop. Once the element mounts,
                <code>current</code> points at the real node, which you can use inside an effect.
            </p>

            <Heading level={2} id="values">Holding values</Heading>
            <p>
                A ref is also handy for any mutable value you want to remember without re-rendering,
                such as a timer id or a previous value.
            </p>
            <PropsTable rows={[
                ['initialValue', 'mixed', 'null', 'The starting value of the current property'],
            ]} />
        </DocPage>
    );
}
