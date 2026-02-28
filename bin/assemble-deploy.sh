#!/usr/bin/env bash
#
# Assemble a Hetzner-ready single-folder deploy into ./deploy
#
# Hetzner Webhosting gives you ONE public folder (the doc-root) and nothing can
# live above it. So everything ships inside that folder, and we keep all the
# sensitive PHP (server.php, api.php, vendor, dist) in an `app/` subfolder that
# .htaccess forbids over HTTP. The doc-root only directly serves index.php and
# the public assets (build/, css/).
#
# Result layout (= the contents of your Hetzner public folder):
#   index.php          front controller
#   .htaccess          routing + lock down app/ + WASM mime + hardening
#   .user.ini          production PHP settings (display_errors off)
#   build/             WASM bundle (public)
#   css/               styles (public)
#   app/               <-- 403 to the web; PHP still require()s it from disk
#     server.php  api.php  dist/  vendor/
#
# Usage:  bin/assemble-deploy.sh
# Then:   upload the CONTENTS of deploy/ into your Hetzner public folder.

set -euo pipefail
cd "$(dirname "$0")/.."

echo "==> composer build (compile src -> dist, pack the WASM bundle)"
composer build

echo "==> assembling ./deploy"
rm -rf deploy
mkdir -p deploy/app

# public, web-served
cp public/index.php deploy/index.php
cp -r public/build  deploy/build
cp -r public/css    deploy/css

# private app code (denied by .htaccess, still readable by PHP from disk)
cp server.php api.php deploy/app/
cp -r dist            deploy/app/dist
cp -r vendor          deploy/app/vendor

# --- .htaccess (doc-root) ---------------------------------------------------
cat > deploy/.htaccess <<'HTACCESS'
# PHPX-Website — production (Hetzner single doc-root). Generated; edit the source.

Options -Indexes
RewriteEngine On

# 1) Forbid dotfiles / VCS / config (.git, .env, .user.ini, .htaccess), keep ACME.
RewriteRule (^|/)\.(?!well-known/) - [F,L]

# 2) Forbid all direct HTTP access to the app code. index.php still require()s
#    these files from disk — that filesystem read is unaffected.
RewriteRule ^app/ - [F,L]

# 3) Serve the real static assets (WASM bundle + css) as files.
RewriteRule ^(build|css)/ - [L]

# 4) Front controller: route everything else to index.php.
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]

# The WASM runtime will not boot without the correct MIME type.
AddType application/wasm .wasm

<IfModule mod_headers.c>
  <FilesMatch "\.(wasm|mjs|data)$">
    Header set Cache-Control "public, max-age=31536000, immutable"
  </FilesMatch>
</IfModule>
HTACCESS

# --- .user.ini (works under FastCGI/FPM, where .htaccess php_flag would 500) --
cat > deploy/.user.ini <<'USERINI'
display_errors = Off
expose_php = Off
USERINI

echo ""
echo "Done -> ./deploy"
echo "Upload the CONTENTS of deploy/ into your Hetzner public folder."
echo "Then verify: https://YOURSITE/app/server.php must return 403."
