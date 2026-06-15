#!/usr/bin/env bash
# Package WordPress theme as cfi.zip for upload to Truehost/cPanel.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
"$ROOT/scripts/build-theme.sh"

cd "$ROOT/wordpress-theme"
rm -f cfi.zip
zip -r cfi.zip cfi -x "*.DS_Store"
echo "✓ Created $ROOT/wordpress-theme/cfi.zip"
ls -lh "$ROOT/wordpress-theme/cfi.zip"
