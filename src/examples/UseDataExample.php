<?php

use function Syntaxx\PHPX\Framework\useData;
use Syntaxx\PHPX\Framework\Environment;

/** Server seeds the data; the client reads the seed (or fetches /api on nav). */
function UseDataExample()
{
    [$todos, $loading] = useData('example-todos', function () {
        if (Environment::isServer()) {
            return ['Learn PHPX', 'Build a component', 'Ship it to production'];
        }
        $window = new Vrzno();
        return $window->fetch('/api/example-todos')->then(fn($r) => $r->text());
    });
    $list = is_array($todos) ? $todos : (is_string($todos) ? (json_decode($todos, true) ?? []) : []);

    return (
        <div data-testid="usedata">
            {$loading ? (
                <div className="text-slate-400">Loading...</div>
            ) : (
                <ul className="list-disc pl-6 text-slate-700">
                    {array_map(fn($t) => <li>{$t}</li>, $list)}
                </ul>
            )}
        </div>
    );
}
