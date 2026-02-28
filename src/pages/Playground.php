<?php

function Playground()
{
    return (
        <div className="max-w-3xl mx-auto px-6 py-24 text-center" data-testid="playground">
            <div className="inline-flex items-center gap-2 bg-violet-100 text-violet-700 rounded-full px-3 py-1 text-sm mb-6">Coming soon</div>
            <h1 className="text-4xl font-extrabold text-slate-900 mb-4">Playground</h1>
            <p className="text-lg text-slate-500 mb-8">
                An in-browser PHPX editor is on the way. Because the compiler and the runtime both run as
                WebAssembly, you will be able to write a component and watch it run right here, with
                nothing to install.
            </p>
            <a href="/docs/getting-started" className="inline-block bg-violet-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-violet-700">
                Start with the docs →
            </a>
        </div>
    );
}
