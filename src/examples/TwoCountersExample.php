<?php

/** Two independent counters — demonstrates per-instance hook state. */
function TwoCountersExample()
{
    return (
        <div className="flex gap-4 items-center" data-testid="two-counters">
            <CounterExample />
            <CounterExample />
            <span className="text-sm text-slate-400">independent state</span>
        </div>
    );
}
