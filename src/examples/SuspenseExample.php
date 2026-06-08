<?php

use function Syntaxx\PHPX\Framework\useSuspenseData;
use Syntaxx\PHPX\Framework\Environment;

/** Child that suspends until its data is ready; the boundary shows a fallback. */
function SuspenseFacts()
{
    $raw = useSuspenseData('suspense-facts', function () {
        if (Environment::isServer()) {
            return ['Suspense shows a fallback while data loads', 'The component carries no loading state itself'];
        }
        $window = new Vrzno();
        return $window->fetch('/api/example-todos')->then(fn($r) => $r->text());
    });
    $list = is_array($raw) ? $raw : (is_string($raw) ? (json_decode($raw, true) ?? []) : []);
    return (
        <ul className="list-disc pl-6 text-slate-700" data-testid="suspense-facts">
            {array_map(fn($t) => <li>{$t}</li>, $list)}
        </ul>
    );
}

function SuspenseExample()
{
    return (
        <Suspense fallback={<div className="text-slate-400" data-testid="suspense-loading">Loading facts...</div>}>
            <SuspenseFacts />
        </Suspense>
    );
}
