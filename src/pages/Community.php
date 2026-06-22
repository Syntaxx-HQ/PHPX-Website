<?php

function Community()
{
    return (
        <div className="max-w-3xl mx-auto px-6 py-16 prose">
            <h1>Community</h1>
            <p className="lead">PHPX is in early development. This is the perfect time to help shape it.</p>

            <h2>Get involved</h2>
            <ul>
                <li><a href="https://github.com/Syntaxx-HQ/PHPX-StarterKit">GitHub</a> - source code, issues, and discussions.</li>
                <li>Try the <a href="/docs/getting-started">starter kits</a> and report what works and what does not.</li>
                <li>Build something and share it - the showcase is hungry for real apps.</li>
            </ul>

            <h2>Roadmap</h2>
            <p>The rendering engine is mature: a Preact-class reconciler, the full hook suite, events, SSR with hydration and streaming, Suspense, and a client router. What is next:</p>
            <ul>
                <li>Selective and out-of-order hydration.</li>
                <li>Concurrent, interruptible rendering.</li>
                <li>Server Components.</li>
                <li>A richer component and tooling ecosystem.</li>
            </ul>

            <h2>Status</h2>
            <p>Current release: <strong>v0.2</strong>. APIs may still change as the framework matures. Pin your dependency and read the changelog before upgrading.</p>
        </div>
    );
}
