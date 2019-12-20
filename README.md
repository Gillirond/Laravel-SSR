*install packages:
npm install
composer install
*create .env file with correct environments
*run migrations:
php artisan migrate
*fill db with data:
php artisan db:seed
*clear and update cache with:
php artisan optimize & php artisan config:cache & php artisan route:cache & php artisan view:clear & php artisan cache:clear
*update(generate) api documentation. It is stored in resources/docs as readme.md file and in public/docs for Postman
php artisan apidoc:generate