<?php

use Syntaxx\PHPX\Framework\Component;

/** Anchored section heading (feeds deep links / the on-this-page TOC). */
function Heading($props)
{
    $level = $props['level'] ?? 2;
    $id = $props['id'] ?? '';
    $children = $props['children'] ?? null;
    $tag = $level === 3 ? 'h3' : 'h2';
    return Component::create($tag, ['id' => $id], [
        $children,
        Component::create('a', ['href' => '#' . $id, 'className' => 'anchor-link', 'aria-label' => 'Link to this section'], ['#']),
    ]);
}
