## Set Up Local

Composer install
cp env.example .env
php artisan migrate
php artisan key:generate
php artisan serve

get LOCAL_API_TOKEN from env.example
use postman or curl
set header
    key:Authorisation value:LOCAL_API_TOKEN

Or (please ignore for code quality) but I created a quick front end
you need to open a new terminal and run: php artisan serve --port 3001

http://127.0.0.1:8000/quotes/ 

## Endpoints
api/kayne/quotes/5/
api/kayne/refresh/5/

5 is an optional parameter which will default to 5

## Running local test suite
php artisan test

