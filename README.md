

## Set Up Local

Composer install
cp env.example .env
php artisan migrate
php artisan serve

sorry you need to generate token ..
new terminal
php artisan tinker
User::factory()->create()
grab the api_token


use postman or curl
set header
    key:Authorisation value:api_token

Please ignore for code quality but created a quick front end
you need to open a new terminal and run: php artisan serve --port 3001
http://127.0.0.1:8000/quotes/ as well

## Endpoints
api/kayne/quotes/5/
api/kayne/refresh/5/

5 is an optional parameter which will default to 5

## Running local test suite
php artisan test

