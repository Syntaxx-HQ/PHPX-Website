<?php

function Features()
{
    return (
        <div className="max-w-6xl mx-auto px-6 py-16" data-testid="features">
            <h1 className="text-4xl font-extrabold text-slate-900 mb-3">See it in action</h1>
            <p className="text-lg text-slate-500 mb-10">
                Pick a feature and watch it run, right here. Every demo is a live PHPX component,
                server-rendered then hydrated. No editing required — just click.
            </p>
            <Sandbox />
            <p className="text-center text-slate-400 text-sm mt-8">
                Want the full set? Browse the <a href="/examples" className="text-violet-600">examples gallery</a>
                or read the <a href="/docs/getting-started" className="text-violet-600">docs</a>.
            </p>
        </div>
    );
}
