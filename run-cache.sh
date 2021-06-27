#!/bin/bash

git pull

# https://laravel.com/docs/8.x/deployment
php composer.phar install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
