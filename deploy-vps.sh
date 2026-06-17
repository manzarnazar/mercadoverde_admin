#!/usr/bin/env bash
set -euo pipefail

# Run this script ON THE VPS inside the mercadoverde_admin project directory.
# Example:
#   cd /var/www/mercadoverde_admin && bash deploy-vps.sh

echo "==> Pulling latest code..."
git pull origin main

echo "==> Clearing Laravel caches..."
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

echo "==> Verifying zone map fix is present..."
if grep -q "__zoneMapV2" public/assets/admin/js/view-pages/common.js; then
    echo "OK: common.js contains zone map v2 fix"
else
    echo "ERROR: common.js is missing zone map fix — git pull may have failed"
    exit 1
fi

echo "==> Done. Hard-refresh admin zone page (Cmd+Shift+R)."
