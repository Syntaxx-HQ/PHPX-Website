<?php

function HooksOverview()
{
    return (
        <DocPage title="Hooks Overview" description="The rules of hooks, and the full list.">
            <p>
                Hooks let a function component hold state and run effects. They are plain functions you
                call at the top of your component.
            </p>

            <Heading level={2} id="rules">The rules of hooks</Heading>
            <ul>
                <li>Call hooks at the top level — never inside a conditional or loop, so the call order stays stable.</li>
                <li>Call hooks only from components or from other hooks, not from regular helpers.</li>
            </ul>

            <Heading level={2} id="list">The hooks</Heading>
            <ul>
                <li><a href="/docs/hooks/use-state">useState</a> — local state.</li>
                <li><a href="/docs/hooks/use-effect">useEffect</a> — side effects.</li>
                <li><a href="/docs/hooks/use-ref">useRef</a> — a stable mutable box.</li>
                <li><a href="/docs/hooks/use-memo">useMemo</a> — memoize a value.</li>
                <li><a href="/docs/hooks/use-callback">useCallback</a> — memoize a function.</li>
                <li><a href="/docs/hooks/use-data">useData</a> — isomorphic data fetching.</li>
                <li><a href="/docs/hooks/use-suspense-data">useSuspenseData</a> — data with Suspense.</li>
            </ul>

            <Callout type="note" title="Server versus client">
                State and memo hooks work on both sides. Effects run only on the client, never during
                server rendering.
            </Callout>
        </DocPage>
    );
}
