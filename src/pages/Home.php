<?php

use function Syntaxx\PHPX\Framework\useState;

/** The live counter shown in the hero preview - matches the source beside it. */
function HeroCounter()
{
    [$count, $setCount] = useState(0);
    return (
        <div className="text-center">
            <div data-testid="live-counter" className="text-5xl font-extrabold text-slate-900 mb-6">Count: {$count}</div>
            <div className="flex items-center justify-center gap-3">
                <button
                    onClick={fn() => $setCount($count - 1)}
                    className="w-16 h-12 rounded-lg border border-slate-300 text-2xl text-slate-700 hover:bg-slate-50 transition"
                >-</button>
                <button
                    data-testid="hero-plus"
                    onClick={fn() => $setCount($count + 1)}
                    className="w-16 h-12 rounded-lg bg-slate-900 text-white text-2xl hover:bg-slate-800 transition"
                >+</button>
            </div>
        </div>
    );
}

/** The hero showcase card: a component's source next to it running live. */
function HeroDemo()
{
    $code = <<<'PHP'
function Counter() {
  [$count, $setCount] = useState(0);
  return (
    <div className="text-center">
      <h1 className="text-2xl font-bold mb-4">
        Count: {$count}
      </h1>
      <div className="flex gap-2">
        <button onClick={fn() => $setCount($count - 1)}
          className="px-4 py-2 border rounded">
        -</button>
        <button onClick={fn() => $setCount($count + 1)}
          className="px-4 py-2 bg-black text-white rounded">
        +</button>
      </div>
    </div>
  );
}
PHP;

    return (
        <div className="grid sm:grid-cols-2 gap-8 items-center">
            <div className="[&_pre]:my-0 [&_pre]:border-0 [&_pre]:whitespace-pre-wrap [&_pre]:break-words [&_pre]:text-[15px]">
                <CodeBlock code={$code} language="php" />
            </div>
            <div className="p-6 flex flex-col items-center justify-center">
                <HeroCounter />
                <div className="mt-10 flex items-center gap-2 text-xs text-slate-400">
                    <span className="w-2 h-2 rounded-full bg-green-500"></span>
                    Running in WebAssembly (in your browser)
                </div>
            </div>
        </div>
    );
}

/** A status indicator for the "currently supported" matrix. */
function StatusDot($props)
{
    $s = $props['status'] ?? 'planned';
    if ($s === 'done') {
        return <span className="inline-flex w-5 h-5 rounded-full bg-emerald-500 text-white items-center justify-center text-xs shrink-0">✓</span>;
    }
    if ($s === 'progress') {
        return <span className="inline-flex w-5 h-5 rounded-full bg-amber-400 shrink-0"></span>;
    }
    if ($s === 'notready') {
        return <span className="inline-flex w-5 h-5 rounded-full bg-red-500 text-white items-center justify-center text-xs shrink-0">✕</span>;
    }
    return <span className="inline-flex w-5 h-5 rounded-full border-2 border-slate-300 shrink-0"></span>;
}

/** A copy-to-clipboard button, done entirely in PHP via VRZNO. Uses the async
 *  Clipboard API in secure contexts and falls back to execCommand otherwise.
 *  Shows a checkmark for 2s after copying. Props: text, testid?, class?. */
function CopyButton($props)
{
    $text = $props['text'] ?? '';
    $idle = $props['class'] ?? 'text-slate-400 hover:text-white';
    [$copied, $setCopied] = useState(false);

    $copy = function () use ($setCopied, $text) {
        $window = new Vrzno();
        $nav = $window->navigator;
        if ($nav->clipboard) {
            // Secure context (https / localhost): the async Clipboard API.
            $nav->clipboard->writeText($text);
        } else {
            // Insecure context (e.g. http over a LAN/WSL IP): navigator.clipboard
            // is undefined, so fall back to a temporary textarea + execCommand.
            $doc = $window->document;
            $ta = $doc->createElement('textarea');
            $ta->value = $text;
            $ta->style->position = 'fixed';
            $ta->style->opacity = '0';
            $doc->body->appendChild($ta);
            $ta->select();
            $doc->execCommand('copy');
            $doc->body->removeChild($ta);
        }
        $setCopied(true);
        $window->setTimeout(fn() => $setCopied(false), 2000);
    };

    return (
        <button
            type="button"
            data-testid={$props['testid'] ?? null}
            aria-label="Copy"
            onClick={$copy}
            className={"shrink-0 transition " . ($copied ? 'text-green-500' : $idle)}
        >
            {$copied
                ? <svg className="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                : <svg className="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="11" height="11" rx="2"></rect><rect x="4" y="4" width="11" height="11" rx="2"></rect></svg>}
        </button>
    );
}

/** The install command block with a copy button (CopyButton). */
function InstallCommands()
{
    $cmds = "composer create-project syntaxx/phpx-starter-kit my-app\ncd my-app\ncomposer wasm\ncomposer serve";
    return (
        <div className="flex items-start justify-between bg-slate-900 text-slate-100 rounded-lg px-5 py-4 font-mono text-sm">
            <div className="space-y-1">
                <div>composer create-project <span className="text-violet-300">syntaxx/phpx-starter-kit </span>my-app</div>
                <div>cd my-app</div>
                <div>composer wasm</div>
                <div>composer serve</div>
            </div>
            <CopyButton text={$cmds} testid="copy-install" class="ml-3 text-slate-400 hover:text-white" />
        </div>
    );
}

/** Marketing home page. */
function Home()
{
    $columns = [
        ['🧩', 'Core', [
            ['done', 'Components (props & children)'],
            ['done', 'Preact-class reconciler'],
            ['done', 'State & hooks'],
            ['done', 'Event handling (delegated)'],
            ['done', 'Suspense'],
            ['done', 'Server-side rendering'],
            ['done', 'Browser execution (WASM)'],
            ['planned', 'Context API'],
        ]],
        ['📝', 'Syntax', [
            ['done', 'JSX elements & attributes'],
            ['done', 'Expressions & fragments'],
            ['done', 'Spread & event props'],
            ['progress', 'JSX text edge cases (;, \', &)'],
        ]],
        ['🔀', 'Routing', [
            ['done', 'Client-side routing'],
            ['planned', 'Route params'],
            ['planned', 'Nested routes'],
            ['planned', 'Route data loaders'],
        ]],
        ['🗄️', 'Data & Forms', [
            ['done', 'Data fetching (useData)'],
            ['done', 'Controlled inputs'],
            ['planned', 'Form validation'],
            ['planned', 'Actions / mutations'],
            ['planned', 'File uploads'],
            ['planned', 'Realtime'],
        ]],
        ['🔧', 'Tooling', [
            ['done', 'PHPX compiler'],
            ['done', 'WASM build pipeline'],
            ['done', 'Dev server'],
            ['done', 'Watch / auto-rebuild'],
            ['progress', 'VS Code support'],
            ['planned', 'Hot reload (HMR)'],
            ['notready', 'Production ready'],
        ]],
    ];

    return (
        <div data-testid="home">
            <section className="relative overflow-hidden border-b border-slate-200">
                <div className="max-w-6xl mx-auto px-6 pt-10 pb-20 lg:pt-12 lg:pb-24">
                    <div className="text-center max-w-3xl mx-auto mb-14">
                        <div className="inline-flex items-center gap-2 bg-violet-100 text-violet-700 rounded-full px-3 py-1 text-sm mb-6">
                            <span className="w-2 h-2 bg-green-500 rounded-full"></span> Technology Preview
                        </div>
                        <h1 className="text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-slate-900">React, in PHP.</h1>
                        <p className="text-xl text-slate-600 mb-8 leading-relaxed">
                            PHPX brings React-like components to PHP - compiled to WebAssembly. The same
                            code renders on the server and runs in the browser.
                        </p>
                        <div className="flex flex-wrap justify-center gap-4">
                            <a href="/docs/getting-started" className="bg-violet-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-violet-700">Get started →</a>
                            <a href="/playground" className="border border-slate-300 text-slate-700 font-semibold px-6 py-3 rounded-lg hover:bg-slate-50">Try the playground</a>
                        </div>
                    </div>
                    <HeroDemo />
                </div>
            </section>

            <section className="bg-slate-50 border-b border-slate-200">
                <div className="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <div className="text-3xl font-extrabold text-slate-900 leading-tight">
                            Get started in 30 seconds.
                        </div>
                        <p className="text-lg text-slate-500 mt-3">Composer and PHP 8.4 are enough.</p>
                    </div>
                    <div>
                        <div className="text-sm text-slate-500 mb-2">Install PHPX in seconds:</div>
                        <InstallCommands />
                        <div className="text-xs text-slate-400 mt-2">Requires PHP 8.4+</div>

                        <div className="text-sm text-slate-500 mt-5 mb-2">OR instruct your agent:</div>
                        <div className="bg-white border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-700 leading-relaxed flex items-start justify-between gap-3">
                            <div>Use PHP on the frontend by running <span className="font-mono text-violet-700">composer create-project syntaxx/phpx-starter-kit</span>, then start the development server.</div>
                            <CopyButton text="Use PHP on the frontend by running composer create-project syntaxx/phpx-starter-kit, then start the development server." testid="copy-agent" class="mt-0.5 text-slate-400 hover:text-violet-600" />
                        </div>
                    </div>
                </div>
            </section>

            <section className="border-t border-slate-200">
                <div className="max-w-3xl mx-auto px-6 pt-24 pb-16 text-center">
                    <h2 className="text-4xl font-extrabold text-slate-900 mb-6">Time to take back the web with PHP.</h2>
                    <div className="text-lg text-slate-500 leading-relaxed">
                        <p>{"PHP became the world's favorite backend language."}</p>
                        <p>JavaScript took over the browser.</p>
                        <p>PHPX is an experiment aiming to change that.</p>
                        <p>Same language. Same components. Everywhere.</p>
                    </div>
                </div>
            </section>

            <section className="max-w-6xl mx-auto px-6 pb-10">
                <div className="flex items-center gap-4 mb-10">
                    <h2 className="text-2xl font-bold text-slate-900 shrink-0">Currently supported</h2>
                    <div className="h-px bg-slate-200 flex-1"></div>
                </div>
                <div className="grid sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    {array_map(fn($col) => (
                        <div>
                            <div className="flex items-center gap-2 mb-4">
                                <span className="text-xl">{$col[0]}</span>
                                <span className="font-semibold text-slate-900">{$col[1]}</span>
                            </div>
                            <ul className="space-y-2.5">
                                {array_map(fn($row) => (
                                    <li className="flex items-center gap-2.5 text-sm text-slate-600">
                                        <StatusDot status={$row[0]} />
                                        <span>{$row[1]}</span>
                                    </li>
                                ), $col[2])}
                            </ul>
                        </div>
                    ), $columns)}
                </div>
                <div className="flex flex-wrap justify-center gap-6 mt-14 text-sm text-slate-500">
                    <span className="flex items-center gap-2"><StatusDot status="done" /> Working</span>
                    <span className="flex items-center gap-2"><StatusDot status="progress" /> In progress</span>
                    <span className="flex items-center gap-2"><StatusDot status="planned" /> Planned</span>
                    <span className="flex items-center gap-2"><StatusDot status="notready" /> Not ready</span>
                </div>
            </section>

            <section className="max-w-6xl mx-auto px-6 pb-24">
                <div className="bg-slate-50 border border-slate-200 rounded-xl px-6 py-5 flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div className="flex items-start gap-3">
                        <span className="inline-flex w-9 h-9 rounded-lg bg-slate-900 text-slate-100 items-center justify-center font-mono text-sm shrink-0">{'>_'}</span>
                        <div className="text-sm text-slate-600">
                            <div className="font-semibold text-slate-900">Early prototype. Rough edges.</div>
                            <div>APIs will change. Things will break. Feedback welcome.</div>
                        </div>
                    </div>
                    <div className="flex flex-col gap-1 text-sm md:text-right">
                        <a href="/community" className="text-violet-600 hover:text-violet-700">Roadmap →</a>
                        <a href="https://github.com/Syntaxx-HQ" className="text-violet-600 hover:text-violet-700">Contributing →</a>
                        <a href="https://github.com/Syntaxx-HQ" className="text-violet-600 hover:text-violet-700">Follow development →</a>
                    </div>
                </div>
            </section>

        </div>
    );
}
