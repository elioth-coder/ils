#!/usr/bin/env bash

# Start the Laravel server in the background
php artisan serve --host=0.0.0.0 --port=8000 &
php artisan queue:work

# Clear and cache config, routes, and views
php artisan config:clear
php artisan route:clear
php artisan view:clear

# for caching the configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache


# clear and optimize the application routes,views,config
php artisan optimize:clear
php artisan optimize

# unlink the storae
rm -R public/storage

# link the storage
php artisan storage:link


# Wait indefinitely to keep the container running
wait
