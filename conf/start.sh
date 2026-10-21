#!/usr/bin/env bash
set -e

# Run deploy scripts in number order
for script in /var/www/html/scripts/*; do
  bash "$script"
done

exec /usr/bin/supervisord -n -c /etc/supervisord.conf
