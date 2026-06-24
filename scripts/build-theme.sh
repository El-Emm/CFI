#!/usr/bin/env bash
# Sync static assets into the WordPress theme folder.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
THEME="$ROOT/wordpress-theme/cfi"

echo "→ Copying assets into theme..."
rm -rf "$THEME/assets"
cp -R "$ROOT/assets" "$THEME/assets"

echo "→ Syncing JavaScript..."
cp "$ROOT/assets/js/main.js" "$THEME/assets/js/main.js"
cp "$ROOT/assets/js/gallery.js" "$THEME/assets/js/gallery.js"
cp "$ROOT/assets/js/stories-home.js" "$THEME/assets/js/stories-home.js"

echo "✓ Theme ready at wordpress-theme/cfi"
du -sh "$THEME"
