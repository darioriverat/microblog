## Installation

You can install PHP Jobsity Challenge as follows.

```bash
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
composer install --no-dev -o
php artisan migrate
php artisan serve
```
