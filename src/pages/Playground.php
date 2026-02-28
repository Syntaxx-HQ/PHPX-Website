<?php

/** Holds the preview root across runs (a closure cannot capture a function-static). */
class PgState
{
    public static $root = null;
    public static int $runs = 0;
}

function pgError(string $msg): string
{
    return '<pre style="color:#dc2626;white-space:pre-wrap;font-size:13px;margin:0">'
        . htmlspecialchars($msg) . '</pre>';
}

/** Eval the server-compiled PHP into a fresh namespace and render it live. */
function pgRender(string $php): void
{
    $window = new Vrzno();
    $output = $window->document->getElementById('playground-output');
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
        if (PgState::$root === null) {
            PgState::$root = \Syntaxx\PHPX\Framework\Runtime::createRoot($output);
        }
        PgState::$root->render(\Syntaxx\PHPX\Framework\Component::create($entry, [], []));
    } catch (\Throwable $e) {
        $output->innerHTML = pgError(get_class($e) . ': ' . $e->getMessage());
    }
}

/**
 * Compile the editor source on the server (where the parser runs), then eval and
 * render the returned PHP live in the browser. The result is fully interactive.
 */
function runPlayground(): void
{
    $window = new Vrzno();
    $output = $window->document->getElementById('playground-output');
    $code = (string) $window->document->getElementById('playground-code')->value;
    $output->innerHTML = '<span style="color:#94a3b8;font-size:13px">Compiling...</span>';

    // Keep the RequestInit flat — VRZNO marshals a nested headers array into a
    // value fetch rejects. The server reads php://input regardless of headers.
    $opts = ['method' => 'POST', 'body' => $code];

    $window->fetch('/api/compile', $opts)
        ->then(fn($r) => $r->text())
        ->then(function ($json) {
            $data = json_decode((string) $json, true);
            if (!is_array($data)) {
                (new Vrzno())->document->getElementById('playground-output')->innerHTML = pgError('Bad response from the compiler.');
                return;
            }
            if (isset($data['error'])) {
                (new Vrzno())->document->getElementById('playground-output')->innerHTML = pgError($data['error']);
                return;
            }
            pgRender($data['php']);
        });
}

function Playground()
{
    $default = <<<'PHPX'
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

    return (
        <div className="max-w-6xl mx-auto px-6 py-12" data-testid="playground">
            <h1 className="text-4xl font-extrabold text-slate-900 mb-3">Playground</h1>
            <p className="text-lg text-slate-500 mb-8">
                Edit the PHPX below and run it. The compiler turns your JSX into PHP, and the result is
                executed live in your browser — the component you see is really running.
            </p>

            <div className="grid lg:grid-cols-2 gap-5 items-start">
                <div>
                    <div className="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Editor</div>
                    <textarea
                        id="playground-code"
                        data-testid="playground-code"
                        spellcheck="false"
                        className="w-full h-96 font-mono text-sm leading-relaxed border border-slate-700 rounded-lg p-4 bg-slate-900 text-slate-100 focus:outline-none focus:ring-2 focus:ring-violet-500"
                    >{$default}</textarea>
                    <button
                        data-testid="playground-run"
                        onClick={fn() => runPlayground()}
                        className="mt-3 bg-violet-600 text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-violet-700 transition"
                    >
                        See it in action
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
