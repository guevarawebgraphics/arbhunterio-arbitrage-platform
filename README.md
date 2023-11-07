# MY_CMS V2.0

-   [Developed by Guevara Web Graphics Studio](https://guevarawebgraphics.com.com)

## Requirements

-   PHP -> 7.3+
-   Composer -> latest version
-   MySQL -> 5.8+

## Installation

1. Clone this repository to your local machine

```sh
$ git clone https://github.com/kingrgdev/my_cms.git
```

2. Create your database

```sh
$ mysql -u root -p

# you should be inside MySQL console to do this:
mysql> CREATE DATABASE my_cms;
```

3. CD to project directory then install composer libraries

```sh
$ cd path/to/my_cms
$ composer install
```

4. Create Laravel .env

```sh
$ cp .env.example .env
$ php artisan key:generate
```

5. Fill in necessary fields in .env file (i.e DB setup, Mail driver, etc...)

6. Migrate and seed your database

```sh
$ php artisan migrate:fresh --seed
```

7. Start Laravel and PHP server

```sh
$ php artisan serve # this will spawn a PHP server that can be accessed at http://127.0.0.1:8000
```

## Usage

1. CD to your project directory (skip if you're still in project directory)

```sh
$ cd path/to/my_cms
```

2. View all routes and its available methods

```sh
$ php artisan route:list
```

3. Use Postman or cURL to send requests to routes

```sh
# example of using cURL
$ curl -X POST 'http://127.0.0.1:8000/api/login' \
-H 'Accept: application/json' \
-F 'email=dev@localhost.io' \
-F 'password=secret'
```

## Developer

-   Guevara Web Graphics Studio

## VERSIONS

1.0 - Native PHP
2.0 - Basic Laravel (For application)
2.1 - Full blast template

## Setup Online Betting

Run php artisan migrate:fresh --seed
Run `php artisan oddsjam_game_event_api:cron`

## Additional Dependencies

1. composer require livewire/livewire:^2.0

2. Laravel Queue & Websockets

-   php artisan queue:work
-   php artisan websockets:serve

Recompile:

If uploading changes into staging environment (with SSL Enabled)

1. npx webpack --mode=production
2. npm run dev
3. Activate HTACCESS force SSL

If local only

1. npx webpack --mode=development
2. npm run dev
3. Deactivate HTACCESS force SSL
