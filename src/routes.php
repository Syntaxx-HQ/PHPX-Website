<?php

/**
 * Single source of truth for navigation + routing.
 *  - topNavItems(): the top marketing nav.
 *  - docsNav(): the documentation sidebar (sections -> items).
 * Both the Sidebar and the App route resolver read these, so they never drift.
 *
 * Each item: ['label' => …, 'path' => …, 'component' => GlobalFunctionName].
 * Hook/clashing pages use a "Doc"/"Api" suffix so the component name never
 * collides with a real framework function/class or the built-in <Suspense>.
 */

function topNavItems(): array
{
    return [
        ['label' => 'Docs', 'path' => '/docs/getting-started'],
        ['label' => 'Playground', 'path' => '/playground'],
        ['label' => 'Community', 'path' => '/community'],
    ];
}

/** Marketing (non-docs) routes: path => component. */
function siteRoutes(): array
{
    return [
        '/' => 'Home',
        '/community' => 'Community',
        '/playground' => 'Playground',
    ];
}

function docsNav(): array
{
    return [
        ['title' => 'Introduction', 'items' => [
            ['label' => 'What is PHPX', 'path' => '/docs/introduction', 'component' => 'Introduction'],
            ['label' => 'Why PHPX', 'path' => '/docs/why-phpx', 'component' => 'WhyPhpx'],
            ['label' => 'How It Works', 'path' => '/docs/how-it-works', 'component' => 'HowItWorks'],
        ]],
        ['title' => 'Getting Started', 'items' => [
            ['label' => 'Quick Start', 'path' => '/docs/getting-started', 'component' => 'GettingStarted'],
            ['label' => 'Installation', 'path' => '/docs/installation', 'component' => 'Installation'],
            ['label' => 'Project Structure', 'path' => '/docs/project-structure', 'component' => 'ProjectStructure'],
            ['label' => 'Your First App', 'path' => '/docs/your-first-app', 'component' => 'FirstApp'],
        ]],
        ['title' => 'Core Concepts', 'items' => [
            ['label' => 'JSX Syntax', 'path' => '/docs/jsx', 'component' => 'JsxSyntax'],
            ['label' => 'PHPX Gotchas', 'path' => '/docs/gotchas', 'component' => 'JsxGotchas'],
            ['label' => 'Components & Props', 'path' => '/docs/components', 'component' => 'ComponentModel'],
            ['label' => 'Rendering & Mounting', 'path' => '/docs/rendering', 'component' => 'Rendering'],
            ['label' => 'Conditionals & Lists', 'path' => '/docs/conditional-and-lists', 'component' => 'ConditionalsLists'],
            ['label' => 'State & Re-rendering', 'path' => '/docs/state-and-rerendering', 'component' => 'StateRerendering'],
        ]],
        ['title' => 'Hooks', 'items' => [
            ['label' => 'Overview', 'path' => '/docs/hooks/overview', 'component' => 'HooksOverview'],
            ['label' => 'useState', 'path' => '/docs/hooks/use-state', 'component' => 'UseStateDoc'],
            ['label' => 'useEffect', 'path' => '/docs/hooks/use-effect', 'component' => 'UseEffectDoc'],
            ['label' => 'useRef', 'path' => '/docs/hooks/use-ref', 'component' => 'UseRefDoc'],
            ['label' => 'useMemo', 'path' => '/docs/hooks/use-memo', 'component' => 'UseMemoDoc'],
            ['label' => 'useCallback', 'path' => '/docs/hooks/use-callback', 'component' => 'UseCallbackDoc'],
            ['label' => 'useData', 'path' => '/docs/hooks/use-data', 'component' => 'UseDataDoc'],
            ['label' => 'useSuspenseData', 'path' => '/docs/hooks/use-suspense-data', 'component' => 'UseSuspenseDataDoc'],
            ['label' => 'Custom Hooks', 'path' => '/docs/hooks/custom-hooks', 'component' => 'CustomHooks'],
        ]],
        ['title' => 'Events', 'items' => [
            ['label' => 'Handling Events', 'path' => '/docs/events', 'component' => 'Events'],
            ['label' => 'Delegation Model', 'path' => '/docs/events/delegation', 'component' => 'EventDelegation'],
            ['label' => 'The Event Object', 'path' => '/docs/events/event-object', 'component' => 'EventObject'],
            ['label' => 'Forms & Inputs', 'path' => '/docs/events/forms-and-inputs', 'component' => 'FormsInputs'],
        ]],
        ['title' => 'The Fiber Engine', 'items' => [
            ['label' => 'Overview', 'path' => '/docs/fiber/overview', 'component' => 'FiberOverview'],
            ['label' => 'Reconciliation & Keys', 'path' => '/docs/fiber/reconciliation', 'component' => 'Reconciliation'],
            ['label' => 'Focus & Caret', 'path' => '/docs/fiber/focus-and-caret', 'component' => 'FocusCaret'],
        ]],
        ['title' => 'Server-Side Rendering', 'items' => [
            ['label' => 'SSR Overview', 'path' => '/docs/ssr/overview', 'component' => 'SsrOverview'],
            ['label' => 'Hydration', 'path' => '/docs/ssr/hydration', 'component' => 'Hydration'],
            ['label' => 'Data Fetching', 'path' => '/docs/ssr/data-fetching', 'component' => 'DataFetching'],
            ['label' => 'Streaming SSR', 'path' => '/docs/ssr/streaming', 'component' => 'StreamingDoc'],
            ['label' => 'Isomorphic Components', 'path' => '/docs/ssr/environment', 'component' => 'EnvironmentDoc'],
        ]],
        ['title' => 'Suspense & Routing', 'items' => [
            ['label' => 'Suspense', 'path' => '/docs/suspense', 'component' => 'SuspenseDoc'],
            ['label' => 'Client Router', 'path' => '/docs/router', 'component' => 'RouterDoc'],
            ['label' => 'Links & Navigation', 'path' => '/docs/router/links', 'component' => 'LinksNavigation'],
        ]],
        ['title' => 'Advanced', 'items' => [
            ['label' => 'The VRZNO Bridge', 'path' => '/docs/advanced/vrzno-bridge', 'component' => 'VrznoBridge'],
            ['label' => 'Performance', 'path' => '/docs/advanced/performance', 'component' => 'Performance'],
            ['label' => 'StrictMode', 'path' => '/docs/advanced/strict-mode', 'component' => 'StrictModeDoc'],
            ['label' => 'Testing', 'path' => '/docs/advanced/testing', 'component' => 'TestingDoc'],
            ['label' => 'Coming from React', 'path' => '/docs/advanced/migration-from-react', 'component' => 'MigrationReact'],
        ]],
        ['title' => 'API Reference', 'items' => [
            ['label' => 'Runtime', 'path' => '/docs/api/runtime', 'component' => 'ApiRuntime'],
            ['label' => 'Component', 'path' => '/docs/api/component', 'component' => 'ApiComponent'],
            ['label' => 'Hooks', 'path' => '/docs/api/hooks', 'component' => 'ApiHooks'],
            ['label' => 'ServerRenderer', 'path' => '/docs/api/server-renderer', 'component' => 'ApiServerRenderer'],
            ['label' => 'StreamRenderer', 'path' => '/docs/api/stream-renderer', 'component' => 'ApiStreamRenderer'],
            ['label' => 'Router', 'path' => '/docs/api/router', 'component' => 'ApiRouter'],
            ['label' => 'Environment', 'path' => '/docs/api/environment', 'component' => 'ApiEnvironment'],
            ['label' => 'ComponentResolver', 'path' => '/docs/api/component-resolver', 'component' => 'ApiComponentResolver'],
            ['label' => 'Built-in Components', 'path' => '/docs/api/built-in-components', 'component' => 'ApiBuiltins'],
        ]],
        ['title' => 'Resources', 'items' => [
            ['label' => 'Examples Gallery', 'path' => '/docs/examples', 'component' => 'ExamplesGallery'],
            ['label' => 'Case Study: TaskBoard', 'path' => '/docs/examples/taskboard', 'component' => 'TaskboardCase'],
            ['label' => 'FAQ', 'path' => '/docs/faq', 'component' => 'Faq'],
            ['label' => 'Glossary', 'path' => '/docs/glossary', 'component' => 'Glossary'],
        ]],
    ];
}

/** Flat path => component map for all docs pages. */
function docsRoutes(): array
{
    $map = [];
    foreach (docsNav() as $section) {
        foreach ($section['items'] as $item) {
            $map[$item['path']] = $item['component'];
        }
    }
    return $map;
}

/**
 * Resolve a path to [componentName, isDocs]. Falls back to ComingSoon for known
 * routes whose page function isn't written yet, and NotFound for unknown paths.
 */
function routeComponent(string $path): array
{
    $site = siteRoutes();
    if (isset($site[$path])) {
        return [function_exists($site[$path]) ? $site[$path] : 'ComingSoon', false];
    }
    $docs = docsRoutes();
    if (isset($docs[$path])) {
        return [function_exists($docs[$path]) ? $docs[$path] : 'ComingSoon', true];
    }
    return ['NotFound', strncmp($path, '/docs', 5) === 0];
}

/** Page title for the <head>. */
function siteTitle(string $path): string
{
    if ($path === '/') {
        return 'PHPX — Take back the web';
    }
    foreach (docsNav() as $section) {
        foreach ($section['items'] as $item) {
            if ($item['path'] === $path) {
                return $item['label'] . ' — PHPX Docs';
            }
        }
    }
    foreach (topNavItems() as $item) {
        if ($item['path'] === $path) {
            return $item['label'] . ' — PHPX';
        }
    }
    $site = siteRoutes();
    if (isset($site[$path])) {
        return ucfirst(trim($path, '/')) . ' — PHPX';
    }
    return 'PHPX';
}
