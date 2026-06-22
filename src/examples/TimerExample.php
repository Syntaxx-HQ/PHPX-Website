<?php

use function Syntaxx\PHPX\Framework\useState;
use function Syntaxx\PHPX\Framework\useEffect;

/** useEffect with a cleanup - starts an interval, clears it on pause/unmount. */
function TimerExample()
{
    [$seconds, $setSeconds] = useState(0);
    [$running, $setRunning] = useState(true);

    useEffect(function () use ($running, $setSeconds) {
        if (!$running) {
            return null;
        }
        $window = new Vrzno();
        $id = $window->setInterval(fn() => $setSeconds(fn($s) => $s + 1), 1000);
        return fn() => $window->clearInterval($id);
    }, [$running]);

    return (
        <div className="flex items-center gap-4">
            <div className="text-3xl font-bold text-violet-700 tabular-nums" data-testid="timer">{$seconds}s</div>
            <button onClick={fn() => $setRunning(!$running)} className="bg-slate-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium">
                {$running ? 'Pause' : 'Resume'}
            </button>
        </div>
    );
}
