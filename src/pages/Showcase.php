<?php

/** Showcase: real applications built with PHPX, running in the browser as WASM. */
function Showcase()
{
    $apps = [
        [
            'icon' => '📝',
            'name' => 'WebWord',
            'tagline' => 'A feature-rich document editor with many capabilities similar to Microsoft Word. Start typing to create your document.',
            'url' => '/editor/index.html',
            'features' => [
                'Rich text formatting (bold, italic, underline)',
                'Font and size selection',
                'Text alignment and indentation',
                'Bulleted and numbered lists',
                'Tables with full editing capabilities',
                'Image insertion',
            ],
        ],
    ];

    return (
        <div className="max-w-5xl mx-auto px-6 py-12" data-testid="showcase">
            <h1 className="text-4xl font-extrabold text-slate-900 mb-3">Showcase</h1>
            <p className="text-lg text-slate-500 mb-10 max-w-2xl">
                Real applications built with PHPX - React-style components in PHP, compiled to
                WebAssembly and running entirely in your browser.
            </p>

            <div className="space-y-6">
                {array_map(fn($app) => (
                    <div className="rounded-2xl border border-slate-200 p-6 md:p-8 flex flex-col md:flex-row md:items-start gap-6 hover:shadow-md transition">
                        <div className="flex-1">
                            <div className="flex items-center gap-3 mb-3">
                                <span className="inline-flex w-11 h-11 rounded-xl bg-violet-100 text-violet-700 items-center justify-center text-2xl shrink-0">{$app['icon']}</span>
                                <h2 className="text-2xl font-bold text-slate-900">{$app['name']}</h2>
                                <span className="text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full px-2.5 py-0.5">Live demo</span>
                            </div>
                            <p className="text-slate-600 mb-4">{$app['tagline']}</p>
                            <ul className="grid sm:grid-cols-2 gap-x-8 gap-y-1.5 text-sm text-slate-600">
                                {array_map(fn($f) => (
                                    <li className="flex items-start gap-2">
                                        <span className="text-violet-500 mt-0.5">•</span>
                                        <span>{$f}</span>
                                    </li>
                                ), $app['features'])}
                            </ul>
                        </div>
                        <div className="shrink-0">
                            <a
                                href={$app['url']}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="inline-flex items-center gap-2 bg-violet-600 text-white font-semibold px-5 py-3 rounded-lg hover:bg-violet-700 whitespace-nowrap"
                            >
                                Launch app →
                            </a>
                        </div>
                    </div>
                ), $apps)}
            </div>
        </div>
    );
}
