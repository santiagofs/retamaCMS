## Setup

run command: composer update

duplicate and rename .env.example to .env with proper configuration

run command: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

run command: php artisan jwt:secret

run command: php artisan migrate

##### Make the storage folder writable
run command: sudo chgrp -R _www storage # _www is your apache user group
run command: sudo chmod -R ug+rwx storage

##### Generate the encryption key
run command: php artisan key:generate