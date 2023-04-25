#!/bin/sh
set -e

app() {
    echo "Installing composer dependencies..."
    composer install

    echo "Starting cron..."
    crond

    echo "Starting PHP-FPM..."
    php-fpm
}

start_horizon_workers() {
    echo "Starting horizon"
    supervisord -c /etc/supervisor/conf.d/horizon.conf

    tail -f /dev/null
}

horizon() {
  echo "Starting Horizon..."
}

case "$1" in
  "app")
      app
  ;;
  "horizon")
      start_horizon_workers
  ;;
  *)
    exec "$@"
  ;;
esac
