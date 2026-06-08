<?php

/** Documentation layout: shared top nav + sticky sidebar + content column. */
function DocsLayout($props)
{
    $path = $props['path'] ?? '';
    $children = $props['children'] ?? null;
    return (
        <div className="min-h-screen flex flex-col bg-white">
            <SiteNav path={$path} />
            <div className="flex flex-1 max-w-7xl mx-auto w-full">
                <Sidebar path={$path} />
                <main className="flex-1 min-w-0 px-6 lg:px-12 py-10">
                    {$children}
                </main>
            </div>
        </div>
    );
}
