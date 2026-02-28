<?php

function FiberOverview()
{
    return (
        <DocPage title="The Fiber Engine" description="Surgical DOM updates that preserve focus.">
            <p>
                At the heart of PHPX is a fiber reconciler. It keeps a persistent tree of fiber nodes
                that mirror your component tree, and on each render it diffs the new output against that
                tree and applies only the minimal set of DOM changes.
            </p>

            <Heading level={2} id="surgical">Surgical patching</Heading>
            <p>
                Because unchanged nodes are never touched, their state is preserved. A focused input
                stays focused, a scroll position stays put, a playing video keeps playing. This is the
                single biggest practical advantage over runtimes that replace innerHTML.
            </p>
            <LiveExample title="Focus survives every update">
                <TextEchoExample />
            </LiveExample>

            <Heading level={2} id="how">How a render works</Heading>
            <ul>
                <li>Your component runs and returns a new element tree.</li>
                <li>The reconciler matches new elements against existing fibers by type and key.</li>
                <li>It updates changed props, inserts new nodes, and removes gone ones.</li>
            </ul>

            <Heading level={2} id="react-fiber">How it relates to React Fiber</Heading>
            <p>
                PHPX borrows the React model — components, hooks, keyed reconciliation, and persistent
                component instances — along with the practical win of surgical updates. It is not a
                reimplementation of React Fiber. The tree is persistent and mutated in place rather than
                double-buffered, and rendering is synchronous: there is no time-slicing, no priority
                lanes, and no concurrent mode.
            </p>
            <p>
                In spirit it sits closer to a persistent virtual-DOM reconciler, in the style of Preact,
                than to React Fiber. That is deliberate — the focus-preserving behavior comes from
                keeping host nodes alive across renders, not from an interruptible scheduler. Concurrent,
                interruptible rendering is on the roadmap, not in the engine today.
            </p>

            <Callout type="note" title="Pluggable backends">
                The reconciler talks to the DOM through an abstract host config. The browser backend
                drives real nodes, a server backend produces HTML, and a fake backend powers headless
                tests — all from the same engine.
            </Callout>
        </DocPage>
    );
}
