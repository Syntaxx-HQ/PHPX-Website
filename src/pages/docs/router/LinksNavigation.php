<?php

function LinksNavigation()
{
    $code = <<<'PHP'
// Internal links are intercepted automatically:
<a href="/docs/getting-started">Getting Started</a>

// External and special links are left alone:
<a href="https://example.com">External</a>
<a href="/file.pdf" target="_blank">Download</a>
PHP;

    return (
        <DocPage title="Links and Navigation" description="How the router decides what to intercept.">
            <p>
                Once the router has started, it intercepts clicks on internal anchor tags and navigates
                with the History API instead of reloading. You write ordinary links.
            </p>
            <CodeBlock code={$code} />

            <Heading level={2} id="left-alone">What is left alone</Heading>
            <ul>
                <li>External links to another origin.</li>
                <li>Links with a target, such as a new tab.</li>
                <li>Clicks with a modifier key, or middle clicks.</li>
                <li>Fragment links to an anchor on the same page.</li>
            </ul>

            <Heading level={2} id="programmatic">Programmatic navigation</Heading>
            <p>Call <code>{'Router::navigate($path)'}</code> from an event handler to navigate in code.</p>
        </DocPage>
    );
}
