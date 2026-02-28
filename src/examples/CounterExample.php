<?php

use function Syntaxx\PHPX\Framework\useState;

/** The canonical live example: a real, interactive counter. */
function CounterExample()
{
    [$count, $setCount] = useState(0);
    return (
        <button
            data-testid="live-counter"
            onClick={fn() => $setCount($count + 1)}
            className="bg-violet-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-violet-700 transition"
        >
            Count: {$count}
        </button>
    );
}
