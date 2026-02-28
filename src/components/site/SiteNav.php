<?php

/** Top navigation shared across the whole site (marketing + docs). */
function SiteNav($props)
{
    $path = $props['path'] ?? '/';
    $active = function ($itemPath) use ($path) {
        if ($itemPath === '/docs/getting-started') {
            return strncmp($path, '/docs', 5) === 0;
        }
        return $path === $itemPath;
    };

    return (
        <header className="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 flex items-center h-16 gap-2">
                <a href="/" className="font-extrabold text-xl tracking-tight mr-4">
                    <span className="text-slate-400">{'<'}</span><span className="text-violet-600">PHPX</span><span className="text-slate-400">{'>'}</span>
                </a>
                <nav className="hidden md:flex items-center gap-1">
                    {array_map(fn($item) => (
                        <a
                            href={$item['path']}
                            className={"px-3 py-2 rounded-md text-sm font-medium " . ($active($item['path']) ? 'text-violet-700 bg-violet-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50')}
                        >
                            {$item['label']}
                        </a>
                    ), topNavItems())}
                </nav>
                <div className="ml-auto flex items-center gap-3">
                    <a href="https://github.com/Syntaxx-HQ" className="hidden sm:inline text-sm text-slate-600 hover:text-slate-900">GitHub</a>
                    <a href="/docs/getting-started" className="bg-gradient-to-br from-violet-600 to-violet-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:opacity-90">
                        Get started
                    </a>
                </div>
            </div>
        </header>
    );
}
