<?php

/** Admonition box: note (blue) / tip (green) / warning (amber) / danger (red). */
function Callout($props)
{
    $type = $props['type'] ?? 'note';
    $title = $props['title'] ?? null;
    $children = $props['children'] ?? null;
    $styles = [
        'note' => 'bg-blue-50 border-blue-400 text-blue-900',
        'tip' => 'bg-green-50 border-green-400 text-green-900',
        'warning' => 'bg-amber-50 border-amber-400 text-amber-900',
        'danger' => 'bg-red-50 border-red-400 text-red-900',
    ];
    $cls = $styles[$type] ?? $styles['note'];
    return (
        <div className={"my-5 border-l-4 rounded-r-lg px-4 py-3 " . $cls}>
            {$title ? <div className="font-semibold mb-1">{$title}</div> : null}
            <div className="text-sm leading-relaxed">{$children}</div>
        </div>
    );
}
