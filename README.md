# PHPX Website

The official website for [PHPX](https://github.com/Syntaxx-HQ/PHPX-Framework) —
marketing, a live examples showcase, and the full documentation. The whole site
is **built with PHPX** (dogfooding): it is server-rendered, then hydrated in the
browser, and every example is a real, running PHPX component.

## Features

- **Server-rendered** with seamless client hydration (the same compiled PHP runs
  on the server and in the browser via WebAssembly).
- **Live documentation** — code samples sit next to the real, interactive
  component they describe.
- **Full coverage** — JSX, components, every hook, events, the fiber engine, SSR,
  hydration, streaming, Suspense, the router, and an API reference.
- **Client-side navigation** — the docs sidebar navigates without full reloads.

## Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js 18+ (for the Playwright test suite)
- A modern browser with WebAssembly support

## Installation

```bash
git clone https://github.com/Syntaxx-HQ/PHPX-Website.git
cd PHPX-Website
composer install
npm install
```

## Development

```bash
composer build     # compile components for the server (dist/) + pack the client WASM
composer serve     # http://localhost:9930
```

`composer install` downloads the framework and the PHP-to-WASM runtime; `composer
build` then compiles the `.php` components for both the server and the client.

## Project Structure

```
PHPX-Website/
├── server.php            # SSR entry: streams the shell, then hydrates
├── api.php               # JSON endpoints for the data-fetching demos
├── bootstrap.php         # WASM client entry -> src/main.php
├── public/
│   ├── index.php         # dev router (static / /api / SSR)
│   ├── css/style.css     # brand + prose styles (Tailwind via CDN)
│   └── build/            # client WASM bundle (gitignored)
├── dist/                 # components compiled for the server (gitignored)
├── src/
│   ├── App.php           # routes a path to a page + layout
│   ├── routes.php        # single source of truth: top nav + docs sidebar
│   ├── main.php          # hydrateRoot + Router::start
│   ├── includes.php      # auto-loads every component / example / page
│   ├── components/       # SiteLayout, DocsLayout, Sidebar, doc primitives
│   ├── examples/         # live example components (CounterExample, ...)
│   └── pages/            # marketing pages + docs/ (one function per page)
├── tests/e2e/            # Playwright (SSR, navigation, live examples)
└── .github/workflows/    # CI
```

## Available Scripts

- `composer build` — full build (server `dist/` + client WASM)
- `composer build:server` — compile components for the server only
- `composer build:client` — pack the client WASM bundle only
- `composer serve` — dev server at `http://localhost:9930`
- `npm test` — run the Playwright end-to-end suite

## How It Works

`server.php` renders the requested route to HTML (the same components that run in
the browser), embeds a JSON seed-state blob, and loads the PHP-WASM runtime. The
client `hydrateRoot`s the server DOM in place — no rebuild, no flash — and
`Router::start` takes over internal navigation. Adding a page is a single PHP
function plus an entry in `src/routes.php`; `includes.php` picks the file up
automatically.

## License

MIT.
