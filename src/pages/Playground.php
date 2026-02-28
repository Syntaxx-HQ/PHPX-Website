<?php

use function Syntaxx\PHPX\Framework\useEffect;

/** Holds the preview root across runs (a closure cannot capture a function-static). */
class PgState
{
    public static $root = null;
    public static int $runs = 0;
}

/** Render an element into the preview root (creating the root once). Routing all
 *  preview content through the reconciler keeps the loading text, result, and
 *  errors swapping cleanly — setting innerHTML directly would desync the root. */
function pgShow($element): void
{
    $window = new Vrzno();
    if (PgState::$root === null) {
        PgState::$root = \Syntaxx\PHPX\Framework\Runtime::createRoot(
            $window->document->getElementById('playground-output')
        );
    }
    PgState::$root->render($element);
}

function pgMessage(string $msg, string $color)
{
    return \Syntaxx\PHPX\Framework\Component::create(
        'div',
        ['style' => 'color:' . $color . ';white-space:pre-wrap;font-size:13px'],
        [$msg]
    );
}

/** Eval the server-compiled PHP into a fresh namespace and render it live. */
function pgRender(string $php): void
{
    try {
        PgState::$runs++;
        $ns = 'PlaygroundRun' . PgState::$runs;
        $use = 'use Syntaxx\\PHPX\\Framework\\Component;'
            . 'use function Syntaxx\\PHPX\\Framework\\useState;'
            . 'use function Syntaxx\\PHPX\\Framework\\useEffect;'
            . 'use function Syntaxx\\PHPX\\Framework\\useRef;'
            . 'use function Syntaxx\\PHPX\\Framework\\useMemo;'
            . 'use function Syntaxx\\PHPX\\Framework\\useCallback;'
            . 'use function Syntaxx\\PHPX\\Framework\\useData;'
            . 'use function Syntaxx\\PHPX\\Framework\\useSuspenseData;';

        eval('namespace ' . $ns . ';' . $use . $php);

        $entry = $ns . '\\Demo';
        if (!function_exists($entry)) {
            throw new \Exception('Define a function named Demo() that returns your component.');
        }
        pgShow(\Syntaxx\PHPX\Framework\Component::create($entry, [], []));
    } catch (\Throwable $e) {
        pgShow(pgMessage(get_class($e) . ': ' . $e->getMessage(), '#dc2626'));
    }
}

/**
 * Compile the editor source on the server (where the parser runs), then eval and
 * render the returned PHP live in the browser. The result is fully interactive.
 */
function runPlayground(): void
{
    $window = new Vrzno();
    $code = $window->getPgCode
        ? (string) $window->getPgCode()
        : (string) $window->document->getElementById('playground-code')->value;
    pgShow(pgMessage('Compiling...', '#94a3b8'));

    // Keep the RequestInit flat — VRZNO marshals a nested headers array into a
    // value fetch rejects. The server reads php://input regardless of headers.
    $opts = ['method' => 'POST', 'body' => $code];

    $window->fetch('/api/compile', $opts)
        ->then(fn($r) => $r->text())
        ->then(function ($json) {
            $data = json_decode((string) $json, true);
            if (!is_array($data)) {
                pgShow(pgMessage('Bad response from the compiler.', '#dc2626'));
                return;
            }
            if (isset($data['error'])) {
                pgShow(pgMessage($data['error'], '#dc2626'));
                return;
            }
            pgRender($data['php']);
        });
}

/** The example snippets offered by the playground select. Each defines Demo(). */
function playgroundExamples(): array
{
    $counter = <<<'PHPX'
function Demo() {
    [$count, $setCount] = useState(0);
    return (
        <button
            onClick={fn() => $setCount($count + 1)}
            style="padding:10px 18px;background:#6d28d9;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:16px"
        >
            Count: {$count}
        </button>
    );
}
PHPX;

    $toggle = <<<'PHPX'
function Demo() {
    [$on, $setOn] = useState(false);
    return (
        <button
            onClick={fn() => $setOn(!$on)}
            style="padding:10px 18px;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:16px;background:{$on ? '#16a34a' : '#94a3b8'}"
        >
            {$on ? 'ON' : 'OFF'}
        </button>
    );
}
PHPX;

    $input = <<<'PHPX'
function Demo() {
    [$text, $setText] = useState('');
    return (
        <div style="font-size:16px">
            <input
                value={$text}
                onInput={fn($e) => $setText($e->target->value)}
                placeholder="Type here..."
                style="border:1px solid #cbd5e1;border-radius:8px;padding:8px 12px;width:100%"
            />
            <p>You typed: {$text}</p>
        </div>
    );
}
PHPX;

    $todo = <<<'PHPX'
function Demo() {
    [$todos, $setTodos] = useState(['Learn PHPX']);
    [$draft, $setDraft] = useState('');
    $add = function () use ($draft, $setDraft, $setTodos) {
        if (trim($draft) === '') return;
        $setTodos(fn($prev) => [...$prev, $draft]);
        $setDraft('');
    };
    return (
        <div style="font-size:16px">
            <input value={$draft} onInput={fn($e) => $setDraft($e->target->value)} style="border:1px solid #cbd5e1;border-radius:8px;padding:6px 10px" />
            <button onClick={$add} style="margin-left:8px;background:#6d28d9;color:#fff;border:none;border-radius:8px;padding:6px 12px;cursor:pointer">Add</button>
            <ul>{array_map(fn($t) => <li>{$t}</li>, $todos)}</ul>
        </div>
    );
}
PHPX;

    $list = <<<'PHPX'
function Demo() {
    [$items, $setItems] = useState(['Apples', 'Bananas']);
    $add = fn() => $setItems(fn($prev) => [...$prev, 'Item ' . (count($prev) + 1)]);
    return (
        <div style="font-size:16px">
            <ul>{array_map(fn($i) => <li>{$i}</li>, $items)}</ul>
            <button onClick={$add} style="background:#6d28d9;color:#fff;border:none;border-radius:8px;padding:6px 12px;cursor:pointer">Add item</button>
        </div>
    );
}
PHPX;

    return [
        ['label' => 'Counter', 'code' => $counter],
        ['label' => 'Toggle', 'code' => $toggle],
        ['label' => 'Text input', 'code' => $input],
        ['label' => 'Todo list', 'code' => $todo],
        ['label' => 'List', 'code' => $list],
    ];
}

/** Load an example into the editor and immediately run it. */
function pgLoadExample($index): void
{
    if ($index === '' || $index === null) {
        return;
    }
    $examples = playgroundExamples();
    $i = (int) $index;
    if (!isset($examples[$i])) {
        return;
    }
    $window = new Vrzno();
    if ($window->setPgCode) {
        $window->setPgCode($examples[$i]['code']);
    } else {
        $window->document->getElementById('playground-code')->value = $examples[$i]['code'];
    }
    runPlayground();
}

function Playground()
{
    // Upgrade the textarea to a syntax-highlighted CodeMirror editor after the
    // client takes over (effects never run on the server, so no-JS gets a plain
    // textarea).
    useEffect(function () {
        $window = new Vrzno();
        if ($window->CodeMirror) {
            $window->initPgEditor('playground-code');
        }
    }, []);

    $examples = playgroundExamples();
    $default = $examples[0]['code'];

    return (
        <div className="max-w-6xl mx-auto px-6 py-12" data-testid="playground">
            <h1 className="text-4xl font-extrabold text-slate-900 mb-3">Playground</h1>
            <p className="text-lg text-slate-500 mb-8">
                Edit the PHPX below and run it. The compiler turns your JSX into PHP, and the result is
                executed live in your browser — the component you see is really running.
            </p>

            <div className="grid lg:grid-cols-2 gap-5 items-start">
                <div>
                    <div className="flex items-center justify-between mb-2 gap-3">
                        <div className="text-xs font-semibold text-slate-400 uppercase tracking-wide">Editor</div>
                        <select
                            data-testid="playground-examples"
                            onChange={fn($e) => pgLoadExample($e->target->value)}
                            className="text-sm border border-slate-300 rounded-lg px-2 py-1.5 bg-white text-slate-700 cursor-pointer"
                        >
                            {array_map(fn($ex, $i) => (
                                <option value={(string) $i}>{$ex['label']}</option>
                            ), $examples, array_keys($examples))}
                        </select>
                    </div>
                    <textarea
                        id="playground-code"
                        data-testid="playground-code"
                        spellcheck="false"
                        className="w-full h-96 font-mono text-sm leading-relaxed border border-slate-700 rounded-lg p-4 bg-slate-900 text-slate-100 focus:outline-none focus:ring-2 focus:ring-violet-500"
                    >{$default}</textarea>
                    <button
                        data-testid="playground-run"
                        onClick={fn() => runPlayground()}
                        className="mt-3 w-full bg-violet-600 text-white font-semibold py-2.5 rounded-lg hover:bg-violet-700 transition"
                    >
                        run
                    </button>
                </div>

                <div>
                    <div className="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Result</div>
                    <div
                        id="playground-output"
                        data-testid="playground-output"
                        className="border border-slate-200 rounded-lg p-8 bg-white flex items-center justify-center"
                        style="min-height: 24rem;"
                    >
                        <span className="text-slate-300 text-sm">Press the button to run the code.</span>
                    </div>
                </div>
            </div>
        </div>
    );
}
