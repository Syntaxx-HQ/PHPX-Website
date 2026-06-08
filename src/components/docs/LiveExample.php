<?php

/**
 * The killer feature: a REAL running component (children) rendered inline, with
 * its source shown below. Because the child is part of the same fiber tree, it
 * SSRs its initial state and hydrates to fully interactive — a live proof of the
 * framework. `code` is a nowdoc string mirroring the example source.
 */
function LiveExample($props)
{
    $children = $props['children'] ?? null;
    $code = $props['code'] ?? '';
    $title = $props['title'] ?? 'Live example';
    return (
        <div className="my-6 border border-slate-200 rounded-xl overflow-hidden shadow-sm" data-testid="live-example">
            <div className="px-4 py-2 bg-slate-50 border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-500 flex items-center gap-2">
                <span className="w-2 h-2 rounded-full bg-green-500"></span>
                {$title}
            </div>
            <div className="p-6 bg-white" data-testid="live-preview">
                {$children}
            </div>
            {$code ? (
                <div className="border-t border-slate-100">
                    <CodeBlock code={$code} language="php" />
                </div>
            ) : null}
        </div>
    );
}
