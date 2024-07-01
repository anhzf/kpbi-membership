#! /bin/sh

source ~/.bashrc
cd ./server
composer install
php artisan migrate --force
