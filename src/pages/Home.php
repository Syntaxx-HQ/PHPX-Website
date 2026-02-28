<?php

use function Syntaxx\PHPX\Framework\useState;

/** The hero live demo: a running counter with a toggle to reveal its source. */
function HeroDemo()
{
    [$showCode, $setShowCode] = useState(false);
    $code = <<<'PHP'
function Counter() {
    [$count, $setCount] = useState(0);
    return (
        <button onClick={fn() => $setCount($count + 1)}>
            Count: {$count}
        </button>
    );
}
PHP;

    return (
        <div className="bg-white/5 backdrop-blur rounded-2xl border border-white/10 p-6">
            <div className="flex items-center justify-between mb-3">
                <span className="text-sm text-violet-200">Live — click it:</span>
                <button
                    data-testid="hero-toggle-code"
                    onClick={fn() => $setShowCode(!$showCode)}
                    className="text-xs text-violet-200 hover:text-white underline underline-offset-2"
                >
                    {$showCode ? 'Hide code' : 'Show code'}
                </button>
            </div>
            <div className="bg-white rounded-xl p-10 flex items-center justify-center">
                <CounterExample />
            </div>
            {$showCode ? (
                <div className="mt-4" data-testid="hero-code">
                    <CodeBlock code={$code} language="php" />
                </div>
            ) : (
                <div className="mt-4 text-xs text-violet-200">
                    A real PHPX component — server-rendered, then hydrated to interactive.
                </div>
            )}
        </div>
    );
}

/** Marketing home page. */
function Home()
{
    $features = [
        ['⚛️', 'React-like hooks', 'useState, useEffect, useRef, useMemo, useData — the API you already know.'],
        ['🧬', 'Fiber engine', 'Surgical DOM updates: only changed nodes mutate, so inputs keep focus and caret.'],
        ['🖥️', 'Isomorphic SSR', 'The same compiled PHP runs on the server and the client — no hydration-mismatch class of bugs.'],
        ['🌊', 'Streaming + Suspense', 'Flush the shell first, stream Suspense boundaries as they resolve.'],
        ['🧭', 'Client router', 'SPA navigation via the History API — without re-booting the WASM runtime.'],
        ['🐘', 'Pure PHP', 'No JavaScript build toolchain to learn. Write fn() not () =>.'],
    ];

    return (
        <div data-testid="home">
            <section className="relative overflow-hidden bg-gradient-to-br from-violet-600 via-violet-700 to-violet-900 text-white">
                <div className="max-w-7xl mx-auto px-6 py-24 lg:py-32 grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-3 py-1 text-sm mb-6">
                            <span className="w-2 h-2 bg-green-400 rounded-full"></span> Early development — v0.2
                        </div>
                        <h1 className="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">Take back the web.</h1>
                        <p className="text-xl text-violet-100 mb-8 leading-relaxed">
                            PHPX brings React-like components to PHP — compiled to WebAssembly. The same
                            code renders on the server and runs in the browser.
                        </p>
                        <div className="flex flex-wrap gap-4">
                            <a href="/docs/getting-started" className="bg-white text-violet-700 font-semibold px-6 py-3 rounded-lg hover:bg-violet-50">Get started →</a>
                            <a href="/playground" className="bg-white/10 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/20">Try the playground</a>
                        </div>
                    </div>
                    <HeroDemo />
                </div>
            </section>

            <section className="max-w-7xl mx-auto px-6 py-20">
                <h2 className="text-3xl font-bold text-center text-slate-900 mb-4">Everything you need, in PHP</h2>
                <p className="text-center text-slate-500 max-w-2xl mx-auto mb-12">
                    The same mental model as React — hooks, components, JSX — without leaving PHP, and
                    without the hydration headaches.
                </p>
                <div className="grid md:grid-cols-3 gap-6">
                    {array_map(fn($f) => (
                        <div className="border border-slate-200 rounded-xl p-6 hover:shadow-md transition">
                            <div className="text-2xl mb-3">{$f[0]}</div>
                            <div className="font-semibold text-slate-900 mb-2">{$f[1]}</div>
                            <div className="text-sm text-slate-600 leading-relaxed">{$f[2]}</div>
                        </div>
                    ), $features)}
                </div>
            </section>

            <section className="bg-slate-900 text-white">
                <div className="max-w-4xl mx-auto px-6 py-20 text-center">
                    <h2 className="text-3xl font-bold mb-4">Ready to try PHPX?</h2>
                    <p className="text-slate-400 mb-8">Build your first component in five minutes.</p>
                    <a href="/docs/getting-started" className="inline-block bg-gradient-to-br from-violet-500 to-violet-700 font-semibold px-8 py-3 rounded-lg hover:opacity-90">
                        Read the docs →
                    </a>
                </div>
            </section>
        </div>
    );
}
