#!/bin/sh

service apache2 start

chown -R entries:www-data ../dariorivera

# Laravel installation
su entries -c "composer install"
su entries -c "chmod -R a+w storage"
su entries -c "chmod a+w bootstrap/cache"
su entries -c "cp .env.example .env"
su entries -c "php artisan key:generate"
su entries -c "php artisan migrate"
su entries -c "php artisan db:seed --class=SampleData"
echo "Entries and Twees has been installed!"

/bin/bash
