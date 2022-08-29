# SMS Service
This is a basic laravel app with Laravel Breeze installed and a minor tweak to the docker configuration to allow it to communicate with another app.

This docker container must be run *before* Telmy By SMS

## Installation

1. Make sure you have Docker installed
2. Clone this repo.
3. The following will create a small docker container to be able to do the equivalent of `composer install`.
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
This is necessary so that the correct version of composer  is used.
4. Start the docker container
```bash
./vendor/bin/sail up -d
```
5. Copy `.env.example` to `.env`.
6. Create a new app key by running
```bash
./vendor/bin/sail php artisan key:generate
```
## Next Steps
Start the app by running `sail npm run dev`
