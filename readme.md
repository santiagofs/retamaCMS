## Setup

run command: composer update

duplicate and rename .env.example to .env with proper configuration

run command: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

run command: php artisan jwt:secret

run command: php artisan migrate
