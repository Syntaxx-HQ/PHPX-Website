<?php

function Features()
{
    $sections = [
        ['React-like hooks', 'The hook API you already know — useState, useEffect, useRef, useMemo, useCallback — plus isomorphic data hooks useData and useSuspenseData. Same mental model, written in PHP.'],
        ['A real fiber engine', 'State updates patch only the DOM nodes that actually changed. Inputs keep their focus and caret across re-renders — the thing an innerHTML-replacement runtime cannot do.'],
        ['Isomorphic SSR', 'The exact same compiled PHP runs on the server (real HTML, instant first paint) and in the browser (WebAssembly). One language, one set of semantics, no hydration-mismatch class of bugs.'],
        ['Streaming and Suspense', 'Flush the shell immediately, then stream each Suspense boundary as its data resolves. Declarative loading states with a single fallback prop.'],
        ['Client-side router', 'Internal links navigate via the History API — no full page reload and no re-booting the WASM runtime. Seamless SPA navigation on top of server-rendered pages.'],
        ['Pure PHP', 'No JavaScript build toolchain to learn. Write components as plain PHP functions, with JSX compiled to Component::create calls. Use fn() for arrow functions and PHP arrays for props.'],
    ];

    return (
        <div className="max-w-4xl mx-auto px-6 py-16">
            <h1 className="text-4xl font-extrabold text-slate-900 mb-3">Features</h1>
            <p className="text-lg text-slate-500 mb-12">Everything you need to build modern, interactive UIs — without leaving PHP.</p>
            <div className="space-y-10">
                {array_map(fn($s, $i) => (
                    <div className="flex gap-5">
                        <div className="flex-shrink-0 w-10 h-10 rounded-lg bg-violet-100 text-violet-700 font-bold flex items-center justify-center">{$i + 1}</div>
                        <div>
                            <h2 className="text-xl font-bold text-slate-900 mb-2">{$s[0]}</h2>
                            <p className="text-slate-600 leading-relaxed">{$s[1]}</p>
                        </div>
                    </div>
                ), $sections, array_keys($sections))}
            </div>
        </div>
    );
}
