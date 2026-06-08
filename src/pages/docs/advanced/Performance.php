<?php

function Performance()
{
    return (
        <DocPage title="Performance" description="Keep your app fast.">
            <Heading level={2} id="cheap">Updates are already cheap</Heading>
            <p>
                The reconciler patches only what changed, and identical state updates bail out before
                rendering. For most apps you do not need to optimize anything.
            </p>

            <Heading level={2} id="tools">When you do</Heading>
            <ul>
                <li>Wrap expensive computations in <a href="/docs/hooks/use-memo">useMemo</a>.</li>
                <li>Give list items stable keys so reorders stay cheap.</li>
                <li>Keep components small so re-renders stay local.</li>
            </ul>

            <Callout type="note" title="Measure first">
                Optimize based on real measurements, not guesses. The browser performance tools work
                normally against a PHPX app.
            </Callout>
        </DocPage>
    );
}
