<?php

use function Syntaxx\PHPX\Framework\useState;

function ToggleExample()
{
    [$on, $setOn] = useState(false);
    return (
        <div className="flex items-center gap-3">
            <button
                data-testid="toggle-btn"
                onClick={fn() => $setOn(!$on)}
                className={"px-4 py-2 rounded-lg font-semibold text-white transition " . ($on ? 'bg-green-600' : 'bg-slate-400')}
            >
                {$on ? 'ON' : 'OFF'}
            </button>
            <span className="text-slate-600">{$on ? 'Enabled' : 'Disabled'}</span>
        </div>
    );
}
