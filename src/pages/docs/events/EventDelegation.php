<?php

function EventDelegation()
{
    return (
        <DocPage title="Event Delegation" description="One listener per type, handlers that survive re-renders.">
            <p>
                PHPX does not attach a listener to every node. It attaches a single listener per event
                type on the root container and dispatches by walking up from the event target to find a
                registered handler.
            </p>

            <Heading level={2} id="why">Why it matters</Heading>
            <ul>
                <li>Handlers are never torn down and re-attached on re-render, so nothing is ever lost.</li>
                <li>Adding or removing elements requires no listener bookkeeping.</li>
                <li>It stays fast even for large trees.</li>
            </ul>

            <Heading level={2} id="mapping">Event name mapping</Heading>
            <p>
                Prop names map to DOM event names by lowercasing - <code>onClick</code> becomes
                <code>click</code>, <code>onInput</code> becomes <code>input</code>. The one special
                case is <code>onDoubleClick</code>, which maps to <code>dblclick</code>.
            </p>

            <Callout type="note" title="Stable identity">
                Each handler is stored under a stable id on its node. That is how a handler keeps
                working across renders without being re-bound.
            </Callout>
        </DocPage>
    );
}
