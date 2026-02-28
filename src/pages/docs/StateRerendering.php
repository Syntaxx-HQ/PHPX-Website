<?php

function StateRerendering()
{
    return (
        <DocPage title="State and Re-rendering" description="What triggers a render, and what does not.">
            <Heading level={2} id="triggers">What triggers a re-render</Heading>
            <p>
                Calling a state setter schedules a re-render of that component. A parent re-rendering
                also re-renders its children. Nothing else does.
            </p>

            <Heading level={2} id="bail-out">Identity bail-out</Heading>
            <p>
                If you set state to a value strictly identical to the current one, PHPX skips the render
                entirely. Redundant updates are therefore cheap.
            </p>

            <Heading level={2} id="per-instance">State is per instance</Heading>
            <p>
                Each rendered component instance keeps its own hook state, indexed by call order. Two
                instances of the same component are completely independent.
            </p>
            <LiveExample title="Two independent counters">
                <TwoCountersExample />
            </LiveExample>

            <Callout type="tip" title="Functional updates">
                When the next value depends on the previous one, pass a function to the setter so you
                always read the latest value.
            </Callout>
        </DocPage>
    );
}
