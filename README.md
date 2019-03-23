# Laravel Lumen Api + JWT Token + MongoDB


## Create API folder

```shell
mkdir api
```

## Download laradock to create setup WebServer and mongodb via docker containers

```shell
git clone https://github.com/Laradock/laradock.git

cd laradock
```


## Modify laradock configuration files.

Rename env_example to .env

```shell
mv env_example .env
```

Open `.env` file and modify the environment variables `APP_CODE_PATH_HOST`, `WORKSPACE_INSTALL_MONGO` and `PHP_FPM_INSTALL_MONGO` to this:

```dotenv
APP_CODE_PATH_HOST=../api


WORKSPACE_INSTALL_MONGO=true


PHP_FPM_INSTALL_MONGO=true

```

## Up docker container to start working development the Lumen API

```shell
docker-compose up -d nginx mongo workspace
```

Confirm that you have 4 docker container running (laradock_nginx, laradock_php-fpm, laradock_workspace, laradock_mongo):

```shell
docker ps

Example: 
CONTAINER ID        IMAGE                COMMAND                  CREATED             STATUS              PORTS                                      NAMES
e1b221357a1d        laradock_nginx       "/bin/bash /opt/star…"   4 seconds ago       Up 2 seconds        0.0.0.0:80->80/tcp, 0.0.0.0:443->443/tcp   laradock_nginx_1
4f6e37665f25        laradock_php-fpm     "docker-php-entrypoi…"   5 seconds ago       Up 4 seconds        9000/tcp                                   laradock_php-fpm_1
a326286a0204        laradock_workspace   "/sbin/my_init"          7 seconds ago       Up 5 seconds        0.0.0.0:2222->22/tcp                       laradock_workspace_1
ed1c485d2717        docker:dind          "dockerd-entrypoint.…"   8 seconds ago       Up 6 seconds        2375/tcp                                   laradock_docker-in-docker_1
7c1dad369b76        laradock_mongo       "docker-entrypoint.s…"   8 seconds ago       Up 6 seconds        0.0.0.0:27017->27017/tcp                   laradock_mongo_1

```

## Create Lumen API

#### Access to docker workspace and create a Lumen API via composer

```dotenv
docker-compose exec workspace bash

composer create-project --prefer-dist laravel/lumen .

```

#### Modify the .env and set your own `APP_KEY` and `JWT_SECRET`

```dotenv
APP_NAME=Lumen
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mongodb
DB_HOST=mongo
DB_PORT=27017
DB_DATABASE=default

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

APP_KEY=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
JWT_SECRET=SJ3N7D4NOE823NKSH287SHHSAKAS29SNA
API_VERSION_ONE=v1

```

#### Edit composer require to add all this packages and run `composer update`

```shell

    "require": {
        "php": ">=7.1.3",
        "firebase/php-jwt": "^5.0",
        "illuminate/container": "^5.8",
        "illuminate/database": "^5.8",
        "illuminate/events": "^5.8",
        "illuminate/support": "^5.8",
        "jenssegers/mongodb": "^3.5",
        "laravel/lumen-framework": "5.8.*",
        "mongodb/mongodb": "^1.0",
        "vlucas/phpdotenv": "^3.3"
    },
```

Modify bootstrap/app.php and add this:


#### Create JwtMiddleware.php


```php
<?php
...


$app->routeMiddleware([
    'jwt.auth' => App\Http\Middleware\JwtMiddleware::class,
]);


$app->register(Jenssegers\Mongodb\MongodbServiceProvider::class);


$app->withFacades();
$app->withEloquent();

```


#### Create migration and users seeder

```shell
php artisan make:migration create_users_table
```

Modify `User.php` to work with mongodb connection and package


Modify `ModelFactory.php` to add fake seeder data


Create `UserTableSeeder.php` to create a demo users with passwords


Modify `DatabaseSeeder.php` to execute `UserTableSeeder::run method`


#### Override default database connection and add mongodb connection

Create `config` folder and create a `database.php` file.

Run `composer dump-autoload` to add new classes to `vendor\composer\autoload_classmap.php`


Then run:

```shell
php artisan migrate
php artisan db:seed
```


#### Create Phones migration and model


## Pending document the development for JWT middleware, AuthController and Phones controllers, routes, Exceptions handler modifications, ect...... (Not enough time for that.)




















