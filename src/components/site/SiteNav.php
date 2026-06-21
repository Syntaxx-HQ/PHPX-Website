<?php

use function Syntaxx\PHPX\Framework\useState;

/** Top navigation shared across the whole site (marketing + docs). */
function SiteNav($props)
{
    $path = $props['path'] ?? '/';
    [$open, $setOpen] = useState(false);
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
                    <span className="text-slate-400">{'<'}</span><span className="text-slate-900">PHP</span><span className="text-violet-600">X</span><span className="text-slate-400">{'>'}</span>
                </a>
                <nav className="hidden md:flex items-center gap-1">
                    {array_map(fn($item) => (
                        <a
                            href={$item['path']}
                            target={$item['target'] ?? null}
                            rel={isset($item['target']) ? 'noopener noreferrer' : null}
                            className={"px-3 py-2 rounded-md text-sm font-medium " . ($active($item['path']) ? 'text-violet-700 bg-violet-50' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50')}
                        >
                            {$item['label']}
                        </a>
                    ), topNavItems())}
                </nav>
                <div className="ml-auto flex items-center gap-2 sm:gap-3">
                    <a href="https://github.com/Syntaxx-HQ/PHPX-StarterKit" className="hidden sm:inline text-sm text-slate-600 hover:text-slate-900">GitHub</a>
                    <a href="/docs/getting-started" className="bg-gradient-to-br from-violet-600 to-violet-800 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:opacity-90">
                        Get started
                    </a>
                    <button
                        type="button"
                        aria-label="Toggle menu"
                        onClick={fn() => $setOpen(!$open)}
                        className="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-md text-slate-700 hover:bg-slate-100"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            {$open
                                ? <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                : <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />}
                        </svg>
                    </button>
                </div>
            </div>

            {$open ? (
                <nav className="md:hidden border-t border-slate-200 bg-white px-4 py-3 space-y-1">
                    {array_map(fn($item) => (
                        <a
                            href={$item['path']}
                            target={$item['target'] ?? null}
                            rel={isset($item['target']) ? 'noopener noreferrer' : null}
                            onClick={fn() => $setOpen(false)}
                            className={"block px-3 py-2 rounded-md text-sm font-medium " . ($active($item['path']) ? 'text-violet-700 bg-violet-50' : 'text-slate-700 hover:bg-slate-50')}
                        >
                            {$item['label']}
                        </a>
                    ), topNavItems())}
                    <a
                        href="https://github.com/Syntaxx-HQ/PHPX-StarterKit"
                        onClick={fn() => $setOpen(false)}
                        className="block px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50"
                    >
                        GitHub
                    </a>
                </nav>
            ) : null}
        </header>
    );
}
