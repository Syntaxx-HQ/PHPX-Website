<?php

function WhyPhpx()
{
    return (
        <DocPage title="Why PHPX" description="One language, both sides — isomorphic by construction.">
            <p>
                Modern web UIs are interactive, which has historically meant JavaScript. PHPX takes a
                different path: compile PHP to WebAssembly and run your components in the browser, with
                the very same code rendering on the server.
            </p>

            <Heading level={2} id="isomorphic">Isomorphic by construction</Heading>
            <p>
                React server-side rendering is hard because two runtimes have to agree. When they drift
                you get hydration mismatches, whole-tree re-renders, and double data-fetching. PHPX
                sidesteps the entire problem: the server and client run the identical compiled PHP, seed
                from the identical state, and therefore always produce identical markup.
            </p>

            <Heading level={2} id="focus">Focus and caret survive</Heading>
            <p>
                Older PHP-in-the-browser approaches re-rendered by replacing innerHTML, which destroyed
                focus on every keystroke. The PHPX fiber engine mutates only the nodes that changed, so
                a controlled input keeps its cursor exactly where it was.
            </p>

            <Heading level={2} id="when">When to use it</Heading>
            <ul>
                <li>You are a PHP team that wants rich, interactive UIs without adopting a JavaScript stack.</li>
                <li>You want server-rendered pages that become a single-page app after load.</li>
                <li>You value one language and one mental model across the whole stack.</li>
            </ul>

            <Callout type="note" title="Early days">
                PHPX is young. The rendering engine is mature, but the surrounding ecosystem is still
                growing. See the <a href="/docs/faq">FAQ</a> for current limitations.
            </Callout>
        </DocPage>
    );
}
