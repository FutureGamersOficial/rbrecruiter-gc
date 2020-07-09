#!/usr/bin/env bash

echo "Preliminary installation starting!"
sleep 3
composer install

echo "Full installation starting!"
sleep 3
php artisan application:install
