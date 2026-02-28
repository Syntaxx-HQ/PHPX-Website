<?php

use function Syntaxx\PHPX\Framework\useState;

/** The demos the sandbox can show: a label, the live component, and its source. */
function sandboxDemos()
{
    $counter = <<<'PHP'
function Counter() {
    [$count, $setCount] = useState(0);
    return (
        <button onClick={fn() => $setCount($count + 1)}>
            Count: {$count}
        </button>
    );
}
PHP;

    $toggle = <<<'PHP'
function Toggle() {
    [$on, $setOn] = useState(false);
    return (
        <button onClick={fn() => $setOn(!$on)}>
            {$on ? 'ON' : 'OFF'}
        </button>
    );
}
PHP;

    $input = <<<'PHP'
function Echo() {
    [$text, $setText] = useState('');
    return (
        <div>
            <input
                value={$text}
                onInput={fn($e) => $setText($e->target->value)}
            />
            <p>You typed: {$text}</p>
        </div>
    );
}
PHP;

    $todo = <<<'PHP'
function Todo() {
    [$todos, $setTodos] = useState(['Learn PHPX']);
    [$draft, $setDraft] = useState('');
    $add = function () use ($draft, $setDraft, $setTodos) {
        $setTodos(fn($prev) => [...$prev, $draft]);
        $setDraft('');
    };
    return (
        <div>
            <input value={$draft} onInput={fn($e) => $setDraft($e->target->value)} />
            <button onClick={$add}>Add</button>
            <ul>
                {array_map(fn($t) => <li>{$t}</li>, $todos)}
            </ul>
        </div>
    );
}
PHP;

    $suspense = <<<'PHP'
function Facts() {
    $facts = useSuspenseData('facts', fn() => fetchFacts());
    return <ul>{array_map(fn($f) => <li>{$f}</li>, $facts)}</ul>;
}

function Page() {
    return (
        <Suspense fallback={<p>Loading...</p>}>
            <Facts />
        </Suspense>
    );
}
PHP;

    return [
        ['label' => 'Counter', 'component' => 'CounterExample', 'code' => $counter],
        ['label' => 'Toggle', 'component' => 'ToggleExample', 'code' => $toggle],
        ['label' => 'Input', 'component' => 'TextEchoExample', 'code' => $input],
        ['label' => 'Todo', 'component' => 'TodoExample', 'code' => $todo],
        ['label' => 'Suspense', 'component' => 'SuspenseExample', 'code' => $suspense],
    ];
}

/** An interactive sandbox: pick a demo, see it run live next to its source. */
function Sandbox()
{
    $demos = sandboxDemos();
    [$active, $setActive] = useState(0);
    $current = $demos[$active];

    return (
        <div className="border border-slate-200 rounded-2xl overflow-hidden shadow-sm" data-testid="sandbox">
            <div className="flex flex-wrap gap-1 p-2 bg-slate-50 border-b border-slate-200">
                {array_map(fn($d, $i) => (
                    <button
                        data-testid={'sandbox-tab-' . $i}
                        onClick={fn() => $setActive($i)}
                        className={"px-3 py-1.5 rounded-lg text-sm font-medium transition " . ($i === $active ? 'bg-violet-600 text-white' : 'text-slate-600 hover:bg-slate-200')}
                    >
                        {$d['label']}
                    </button>
                ), $demos, array_keys($demos))}
            </div>
            <div className="grid md:grid-cols-2">
                <div
                    className="p-8 bg-white flex items-center justify-center border-b md:border-b-0 md:border-r border-slate-100"
                    style="min-height: 220px;"
                    data-testid="sandbox-preview"
                >
                    {Component::create($current['component'], [], [])}
                </div>
                <div className="bg-slate-900 min-w-0">
                    <CodeBlock code={$current['code']} language="php" />
                </div>
            </div>
        </div>
    );
}
