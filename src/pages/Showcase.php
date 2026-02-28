<?php

/** Live examples gallery — every demo is a real, running PHPX component. */
function Showcase()
{
    $demos = [
        ['Counter', 'useState and an onClick handler.', Component::create('CounterExample', [], [])],
        ['Toggle', 'Boolean state and conditional rendering.', Component::create('ToggleExample', [], [])],
        ['Controlled input', 'Two-way binding with onInput — focus is preserved.', Component::create('TextEchoExample', [], [])],
        ['Todo list', 'State, lists, keyboard events, add and remove.', Component::create('TodoExample', [], [])],
        ['Data fetching', 'useData — server-seeded, no refetch on the client.', Component::create('UseDataExample', [], [])],
        ['Suspense', 'A boundary shows a fallback while data loads.', Component::create('SuspenseExample', [], [])],
    ];

    return (
        <div className="max-w-5xl mx-auto px-6 py-16" data-testid="showcase">
            <h1 className="text-4xl font-extrabold text-slate-900 mb-3">Live examples</h1>
            <p className="text-lg text-slate-500 mb-10">
                Every example below is a real PHPX component — server-rendered, then hydrated in your
                browser. Go ahead and interact with them.
            </p>
            <div className="grid md:grid-cols-2 gap-6">
                {array_map(fn($d) => (
                    <div className="border border-slate-200 rounded-xl overflow-hidden">
                        <div className="px-4 py-3 border-b border-slate-100">
                            <div className="font-semibold text-slate-900">{$d[0]}</div>
                            <div className="text-sm text-slate-500">{$d[1]}</div>
                        </div>
                        <div className="p-6">{$d[2]}</div>
                    </div>
                ), $demos)}
            </div>
            <div className="mt-12 text-center">
                <a href="/docs/getting-started" className="inline-block bg-violet-600 text-white font-semibold px-6 py-3 rounded-lg">Start building →</a>
            </div>
        </div>
    );
}
