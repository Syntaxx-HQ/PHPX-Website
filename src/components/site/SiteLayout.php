<?php

/** Marketing layout: top nav + full-bleed page content + footer. */
function SiteLayout($props)
{
    $path = $props['path'] ?? '/';
    $children = $props['children'] ?? null;
    return (
        <div className="min-h-screen flex flex-col bg-white">
            <SiteNav path={$path} />
            <main className="flex-1">{$children}</main>
            <SiteFooter />
        </div>
    );
}
