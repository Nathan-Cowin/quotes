

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
http://127.0.0.1:8000/quotes/

## endpoints
api/kayne/quotes/5/
api/kayne/quotes/5/refresh

you can change 5 for number of quotes you want

## Running local test suite
php artisan test

