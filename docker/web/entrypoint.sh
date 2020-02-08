#!/bin/sh

service apache2 start

chown -R jobsity:www-data ../dariorivera

# Laravel installation
su jobsity -c "composer install"
su jobsity -c "chmod -R a+w storage"
su jobsity -c "chmod a+w bootstrap/cache"
su jobsity -c "cp .env.example .env"
su jobsity -c "php artisan key:generate"
su jobsity -c "php artisan migrate"
su jobsity -c "php artisan db:seed --class=SampleData"
echo "Entries and Twees has been installed!"

/bin/bash
