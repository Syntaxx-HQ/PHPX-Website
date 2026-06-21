<?php

function Introduction()
{
    return (
        <DocPage title="What is PHPX" description="React-like components in PHP, compiled to WebAssembly.">
            <p>
                PHPX brings the component model of React to PHP. You write components as plain PHP
                functions that return JSX, and the compiler turns them into standard PHP. That PHP runs
                in two places: natively on the server to produce HTML, and as WebAssembly in the browser
                to make the page interactive.
            </p>

            <Heading level={2} id="model">The model</Heading>
            <p>
                If you know React, you already know PHPX: components, props, children, hooks, JSX, and a
                virtual DOM with a reconciler. The difference is the language and the runtime - PHP
                everywhere, WebAssembly in the browser.
            </p>

            <Heading level={2} id="different">How it differs</Heading>
            <ul>
                <li>Unlike Blade or Twig, components are interactive and run on the client.</li>
                <li>Unlike Livewire, there is no server round-trip per interaction - the component runs in the browser.</li>
                <li>Unlike React, there is no separate JavaScript runtime and no hydration-mismatch class of bugs, because the same compiled PHP runs on both sides.</li>
            </ul>

            <Heading level={2} id="next">Next</Heading>
            <ul>
                <li><a href="/docs/getting-started">Getting Started</a> - build your first app.</li>
                <li><a href="/docs/why-phpx">Why PHPX</a> - the philosophy.</li>
                <li><a href="/docs/how-it-works">How It Works</a> - the build pipeline.</li>
            </ul>
        </DocPage>
    );
}
