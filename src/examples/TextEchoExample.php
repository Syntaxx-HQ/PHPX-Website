<?php

use function Syntaxx\PHPX\Framework\useState;

/** Controlled input - proves focus/caret survive re-renders (the reconciler win). */
function TextEchoExample()
{
    [$text, $setText] = useState('');
    return (
        <div className="space-y-3">
            <input
                data-testid="echo-input"
                type="text"
                value={$text}
                onInput={fn($e) => $setText($e->target->value)}
                placeholder="Type something..."
                className="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-violet-400"
            />
            <div className="text-slate-700">
                You typed: <span data-testid="echo-output" className="font-semibold text-violet-700">{$text}</span>
            </div>
            <div className="text-xs text-slate-400">{strlen($text)} characters - focus stays put on every keystroke.</div>
        </div>
    );
}
