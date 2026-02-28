<?php

function ProjectStructure()
{
    $tree = <<<'TXT'
my-app/
  bootstrap.php        # client entry, loaded inside PHP-WASM
  public/
    index.html         # contains <div id="root">
    build/             # compiled WASM output (generated)
  src/
    main.php           # mounts the root component
    App.php            # your root component
    Components/        # the rest of your components
  composer.json
TXT;

    return (
        <DocPage title="Project Structure" description="Where things live in a PHPX app.">
            <CodeBlock code={$tree} language="text" />

            <Heading level={2} id="entry">The entry points</Heading>
            <ul>
                <li><code>bootstrap.php</code> runs first inside the WASM runtime and requires your main file.</li>
                <li><code>src/main.php</code> grabs the root element and mounts your app with <code>createRoot</code>.</li>
                <li><code>public/index.html</code> holds the root element and the script tag that loads the runtime.</li>
            </ul>

            <Heading level={2} id="components">Components</Heading>
            <p>
                Components are global functions. Keep one per file and require them from your main file
                (or autoload them) so the names are defined before rendering.
            </p>

            <Callout type="note" title="Compiled output">
                The build compiles your source into plain PHP and packs it. Generated directories like
                <code>build</code> are not meant to be edited or committed.
            </Callout>
        </DocPage>
    );
}
