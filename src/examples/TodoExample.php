<?php

use function Syntaxx\PHPX\Framework\useState;

function TodoExample()
{
    [$todos, $setTodos] = useState(['Learn PHPX']);
    [$draft, $setDraft] = useState('');

    $add = function () use ($draft, $setDraft, $setTodos) {
        $t = trim($draft);
        if ($t === '') {
            return;
        }
        $setTodos(fn($prev) => [...$prev, $t]);
        $setDraft('');
    };
    $remove = fn($i) => $setTodos(fn($prev) => array_values(
        array_filter($prev, fn($_, $k) => $k !== $i, ARRAY_FILTER_USE_BOTH)
    ));

    return (
        <div className="space-y-3 max-w-sm" data-testid="todo">
            <div className="flex gap-2">
                <input
                    data-testid="todo-input"
                    value={$draft}
                    onInput={fn($e) => $setDraft($e->target->value)}
                    onKeyPress={fn($e) => $e->key === 'Enter' ? $add() : null}
                    placeholder="Add a todo..."
                    className="flex-1 border border-slate-300 rounded-lg px-3 py-2"
                />
                <button data-testid="todo-add" onClick={$add} className="bg-violet-600 text-white px-4 rounded-lg font-medium">Add</button>
            </div>
            <ul className="space-y-1" data-testid="todo-list">
                {array_map(fn($todo, $i) => (
                    <li className="flex items-center justify-between bg-slate-50 rounded-lg px-3 py-2">
                        <span>{$todo}</span>
                        <button onClick={fn() => $remove($i)} className="text-red-500 text-sm hover:underline">remove</button>
                    </li>
                ), $todos, array_keys($todos))}
            </ul>
        </div>
    );
}
