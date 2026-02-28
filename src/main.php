<?php

use Syntaxx\PHPX\Framework\Component;
use Syntaxx\PHPX\Framework\Runtime;
use Syntaxx\PHPX\Framework\Router;

require_once __DIR__ . "/App.php";

// Adopt the server-rendered #root instead of clearing + rebuilding it.
$window = new Vrzno();
$root = $window->document->getElementById("root");

// hydrateRoot(document.getElementById("root")).render(<App />);
$app = Runtime::hydrateRoot($root);
$app->render(<App />);

// Client-side navigation: internal link clicks (and back/forward) re-render in
// place — no full page reload, no PHP-WASM reboot.
Router::start(function () use ($app) {
    $app->render(Component::create("App", [], []));
});
