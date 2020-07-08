#!/usr/bin/env bash

echo "[!! Welcome! The application will now run through all necessary steps to make sure everything works. !!]"

echo ">> Installing PHP dependencies..."
composer install

echo ">> Installing Javascript dependencies..."
npm install

echo ">> Building scripts..."
npm run dev

echo ">> Configuring Homestead database...";
cp .env.example .env

echo ">> Generating secure application key..."
php artisan key:generate

sed -i 's/laravel/homestead/g' .env
sed -i 's/root/homestead/g' .env
sed -i 's/password/secret/g' .env

echo "!! Warning! Many other options, such as Recaptcha, IP location, and email sending have not been configured automatically. "

echo ">> Running migrations..."
php artisan migrate
php artisan db:seed

php artisan config:cache

echo "Enjoy! Install finished."
