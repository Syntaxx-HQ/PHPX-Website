<?php

/** Standard documentation page shell: title + lead + body. */
function DocPage($props)
{
    $title = $props['title'] ?? '';
    $description = $props['description'] ?? '';
    $children = $props['children'] ?? null;
    return (
        <article className="prose" data-testid="doc-page">
            <h1>{$title}</h1>
            {$description ? <p className="lead">{$description}</p> : null}
            {$children}
        </article>
    );
}
