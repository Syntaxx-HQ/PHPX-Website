# Deploying PHPX-Website to Hetzner (single doc-root)

Hetzner Webhosting gives you **one public folder** (the doc-root) and you can't
put files above it. PHPX-Website is a **PHP SSR app**, not a static site — it
needs `vendor/`, `dist/`, `server.php`, and `api.php` at runtime. So those have
to ship *inside* the public folder, which means they'd be web-reachable unless
locked down. This setup does exactly that.

## The layout

All sensitive code goes into one `app/` subfolder that `.htaccess` forbids over
HTTP; the doc-root only serves `index.php` and the public assets:

```
<your Hetzner public folder>/
  index.php        # front controller (the only PHP entry point)
  .htaccess        # routing + locks down app/ + WASM mime + hardening
  .user.ini        # display_errors off, expose_php off
  build/           # WASM bundle  (public)
  css/             # styles       (public)
  app/             # <-- 403 to the web; PHP still reads it from disk
    server.php  api.php  dist/  vendor/
```

`index.php` `require()`s `app/server.php` / `app/api.php` from **disk** — the
`.htaccess` `403` only blocks **HTTP** access, not PHP's filesystem reads.

## Steps

1. **Build the deploy folder** (locally):
   ```bash
   bin/assemble-deploy.sh
   ```
   This runs `composer build` and assembles `./deploy` in the layout above
   (including the `.htaccess` and `.user.ini`).

2. **Upload the *contents* of `deploy/`** into your Hetzner public folder over
   FTP/SFTP. Upload the `.wasm` / `.data` / `.mjs` files as **binary**.
   - Make sure hidden files (`.htaccess`, `.user.ini`) are included — many FTP
     clients hide dotfiles by default.
   - Do **not** upload `.git`, `src/`, `node_modules/`, `tests/`, or `composer.*`
     — `assemble-deploy.sh` already leaves them out.

3. **Verify it's locked down** after upload:
   - `https://YOURSITE/` → the site renders. ✅
   - `https://YOURSITE/app/server.php` → **403 Forbidden**. ✅
   - `https://YOURSITE/app/vendor/autoload.php` → **403**. ✅
   - `https://YOURSITE/.git/config` → **403/404** (and you didn't upload it). ✅
   - The playground (`/playground`) compiles and runs. ✅

## Security measures (what protects what)

| Risk | Mitigation |
|---|---|
| `vendor/`, `dist/`, `server.php`, `api.php` are inside the web root | `.htaccess` `RewriteRule ^app/ - [F,L]` → **403** for any `/app/...` URL |
| `.htaccess` bypassed by a server misconfig | `server.php` + `api.php` also `exit('Forbidden')` on direct web access (they require the front controller's `PHPX_ENTRY` marker) |
| `.git`, `.env`, `.user.ini` leakage | `.htaccess` blocks all dotfiles (except `.well-known`); and `assemble-deploy.sh` never copies them |
| Directory listing of `build/`, `app/` | `Options -Indexes` |
| Error messages leaking paths / stack traces | `.user.ini` `display_errors = Off`; `expose_php = Off` hides the PHP version |
| `/api/compile` abuse | It only **parses** input (never executes it on the server) and returns the compiled PHP string; input is capped at **100 KB** to prevent parser DoS |
| WASM fails to boot | `AddType application/wasm .wasm` (wrong MIME breaks streaming compilation) |

### Notes / residual risks

- **`/api/compile` is a public, unauthenticated endpoint.** It's low-risk on the
  server (parse-only, size-capped, no execution), but it is still compute on
  demand. If you don't want a public compile endpoint, you can remove the
  `/api/compile` branch from `api.php` and the playground will simply stop
  compiling (the rest of the site is unaffected).
- **Streaming SSR** may be buffered by Hetzner's FastCGI (the page arrives in one
  chunk instead of streaming). Cosmetic — everything still works.
- **PHP version:** needs 8.x (8.3+/8.4). Set it in the Hetzner panel if needed.
- **Slimmer upload (optional):** the deploy copies the full `vendor/`. To drop the
  build-only dev deps, run `composer install --no-dev` before
  `assemble-deploy.sh` (the compiler stays — it's a runtime `require`), then
  `composer install` afterwards to restore your dev environment.
