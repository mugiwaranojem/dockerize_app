# dockerize_app
Simple crud app dockerized  setup

# API setup
cd api
composer install
// update credentails in api/.env file
php artisan migrate

# Client/frontend setup
cd client
npm install
npm run dev

# site address
http://localhost:8081

