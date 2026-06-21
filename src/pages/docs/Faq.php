<?php

function Faq()
{
    return (
        <DocPage title="FAQ" description="Common questions and answers.">
            <Heading level={2} id="production">Is PHPX production ready</Heading>
            <p>
                PHPX is in early development. The rendering engine is mature and well tested, but the
                surrounding ecosystem is still small and APIs may change. Pin your dependency version.
            </p>

            <Heading level={2} id="bundle">How big is the bundle</Heading>
            <p>
                The WASM runtime is a few megabytes, downloaded once and cached. Your app code adds a
                much smaller amount on top.
            </p>

            <Heading level={2} id="seo">Is it good for SEO</Heading>
            <p>
                Yes. With server-side rendering, search engines receive fully rendered HTML before any
                WebAssembly loads.
            </p>

            <Heading level={2} id="focus">Why did inputs lose focus before</Heading>
            <p>
                Older PHP-in-the-browser runtimes replaced innerHTML on every change, which destroyed
                focus. The reconciler fixes this by patching only what changed.
            </p>

            <Heading level={2} id="notfound">My component renders empty</Heading>
            <p>
                Make sure its function is defined before you render, and that the name is capitalized.
                Lowercase names are treated as HTML elements.
            </p>
        </DocPage>
    );
}
