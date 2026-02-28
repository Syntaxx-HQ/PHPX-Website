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

            <Callout type="note" title="Pluggable backends">
                The reconciler talks to the DOM through an abstract host config. The browser backend
                drives real nodes, a server backend produces HTML, and a fake backend powers headless
                tests — all from the same engine.
            </Callout>
        </DocPage>
    );
}
