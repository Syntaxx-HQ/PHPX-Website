<?php

/** Docs sidebar - renders docsNav() with active-link highlighting. */
function Sidebar($props)
{
    $path = $props['path'] ?? '';
    return (
        <aside
            className="hidden lg:block w-64 flex-shrink-0 border-r border-slate-200 py-8 pr-4 overflow-y-auto"
            style="position: sticky; top: 4rem; max-height: calc(100vh - 4rem);"
            data-testid="sidebar"
        >
            {array_map(fn($section) => (
                <div className="mb-6">
                    <div className="px-3 mb-2 text-xs font-bold uppercase tracking-wide text-slate-400">
                        {$section['title']}
                    </div>
                    {array_map(fn($item) => (
                        <a
                            href={$item['path']}
                            className={"sidebar-link" . ($item['path'] === $path ? ' active' : '')}
                        >
                            {$item['label']}
                        </a>
                    ), $section['items'])}
                </div>
            ), docsNav())}
        </aside>
    );
}
