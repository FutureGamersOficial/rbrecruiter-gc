#!/usr/bin/env bash

echo "Preliminary installation starting!"
sleep 3
composer install

echo "Full installation starting!"
php artisan application:install
