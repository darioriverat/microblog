# Entries and Tweets

This application is designed to show the knowledge and expertise about web technologies,
and creation of robust PHP web applications with attention to software architecture and security.

# Installation

This application was developed with Laravel 6x, most of the following steps are related to laravel
installation and configuration.

## Server requirements

As any Laravel application, you will need to make sure your server meets the following requirements.

- PHP >= 7.2.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installing Laravel

Make sure you have composer installed in your machine and execute the following command to install the
dependencies.

```bash
composer install
```

## Configuration

Set up permission of `storeage` and `bootstrap/cache` directories.

```bash
chmod -R a+w storage
chmod a+w bootstrap/cache
```

Set up the environment variables copying the `.env.example` file.

```bash
cp .env.example .env
```

Make sure to set up at least the `DB_* variables with the database information.
Finally, generate the key for the application.

```bash
php artisan key:generate
```

## Database

To create the database schema execute the following commands to run the migrations.

```bash
php artisan migrate
```

## Sample Data

Install some sample data executing the following seeder.

```bash
php artisan db:seed --class=SampleData
```

## Twitter integration

For twitter integration set up the following variables with the appropriate values.

```properties
TWITTER_API_KEY=
TWITTER_API_SECRET_KEY=
TWITTER_API_ACCESS_TOKEN=
TWITTER_API_ACCESS_TOKEN_SECRET=
```


