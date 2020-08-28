# Entries and Tweets

This is a simple microblogging app with Twitter integration.

You can download this project as follows.

```bash
git clone https://github.com/darioriverat/entries-with-twitter-integration
```

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

Further, you need at least MySQL 5.7.

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

Make sure to set up at least the `DB_*` variables with the database information.
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

You could use the following user to log in

```text
email: admin@admin.com
pass:  password
```

## Twitter integration

For twitter integration set up the following variables with the appropriate values.

```properties
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET_KEY=
```

# Docker Installation

You can take advantage of Docker capabilities to install this project. You only need execute the
following command.

```bash
docker-compose up --build -d
```

After you executed this command, you should wait a few minutes until the background process ends
processing. You can be sure of this by looking the output of the following command.

```bash
$ docker logs entries_app | tail -n1
Entries and Twees has been installed!
```

To see the application in action you should access to `http://127.0.0.1:8085/`. Keep in mind
you also need to set up twitter variables if you want to have twitter integration.
