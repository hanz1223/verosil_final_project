#!/usr/bin/env bash
set -e

# Dynamically assign Render's port environment variable, default to 80 if local
PORT_TO_USE=${PORT:-80}
sed -i "s/Listen 80/Listen ${PORT_TO_USE}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT_TO_USE}/" /etc/apache2/sites-available/*.conf

# Laravel configuration and setup
php artisan storage:link || true
php artisan db:seed || true
# Run migrations FIRST, then seed
php artisan migrate --force || true


php artisan optimize || true

# Execute Apache in the foreground replacing the shell process (PID 1)
exec apache2-foreground