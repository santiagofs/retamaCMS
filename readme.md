## Setup

##### Move to the retama folder
cd retama

##### Update dependencies
run command: composer update

##### App configuration
duplicate and rename .env.example to .env with proper configuration

##### Enable JWT
run command: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
run command: php artisan jwt:secret

##### Run migrations
run command: php artisan migrate

##### Make the storage folder writable
run command: sudo chgrp -R _www storage 
run command: sudo chgrp -R _www storage

##### Generate the encryption key
run command: php artisan key:generate