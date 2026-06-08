<?php

function SiteFooter()
{
    return (
        <footer className="bg-slate-900 text-slate-400 mt-24">
            <div className="max-w-7xl mx-auto px-6 py-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div className="sm:col-span-2 lg:col-span-1">
                    <div className="font-extrabold text-lg mb-2"><span className="text-slate-500">{'<'}</span><span className="text-violet-400">PHPX</span><span className="text-slate-500">{'>'}</span></div>
                    <p className="text-sm leading-relaxed">React-like components in PHP, compiled to WebAssembly. Server-rendered, then hydrated.</p>
                </div>
                <div>
                    <div className="text-white font-semibold mb-3 text-sm">Docs</div>
                    <a href="/docs/getting-started" className="block text-sm py-1 hover:text-white">Getting Started</a>
                    <a href="/docs/jsx" className="block text-sm py-1 hover:text-white">JSX Syntax</a>
                    <a href="/docs/hooks/overview" className="block text-sm py-1 hover:text-white">Hooks</a>
                    <a href="/docs/ssr/overview" className="block text-sm py-1 hover:text-white">SSR</a>
                </div>
                <div>
                    <div className="text-white font-semibold mb-3 text-sm">Explore</div>
                    <a href="/playground" className="block text-sm py-1 hover:text-white">Playground</a>
                    <a href="/community" className="block text-sm py-1 hover:text-white">Community</a>
                </div>
                <div>
                    <div className="text-white font-semibold mb-3 text-sm">Project</div>
                    <a href="https://github.com/Syntaxx-HQ" className="block text-sm py-1 hover:text-white">GitHub</a>
                    <a href="/docs/faq" className="block text-sm py-1 hover:text-white">FAQ</a>
                </div>
            </div>
            <div className="border-t border-slate-800 text-center text-xs py-6">© 2026 PHPX — MIT licensed. Built with PHPX.</div>
        </footer>
    );
}
