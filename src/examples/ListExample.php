<?php

use function Syntaxx\PHPX\Framework\useState;

function ListExample()
{
    [$items, $setItems] = useState(['Apples', 'Bananas', 'Cherries']);
    $add = fn() => $setItems(fn($prev) => [...$prev, 'Item ' . (count($prev) + 1)]);
    return (
        <div className="space-y-3">
            <ul className="list-disc pl-6 text-slate-700" data-testid="list">
                {array_map(fn($item) => <li>{$item}</li>, $items)}
            </ul>
            <button data-testid="list-add" onClick={$add} className="bg-violet-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium">Add item</button>
        </div>
    );
}
