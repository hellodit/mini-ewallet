## Mini E-wallet
RESTAPI Mini Ewallet implementation build with PHP Laravel 

## Documentation 
Via [Postman Documenter](https://documenter.getpostman.com/view/4080490/T17J7mKo?version=latest)

## How to run to your local
- Clone this repository `https://github.com/hellodit/mini-ewallet`
- Create MySQL database table
- Rename .env.example file to .env inside your project root and fill the database information.
- Open the console and cd your project root directory
- Run `composer install `or php composer.phar install
- Run `php artisan key:generate` to generate secret key
- Run `php artisan migrate` to migrate database schemes
- Run `php artisan passport:install` to generate 
- Run `php artisan db:seed` to run seeders
- Run `php artisan serve`
- You can now access your project at `localhost:8000` :)

## Main features 
- User
  - Login
  - Register 
  - Logout 
  - Profile 
- Transaction
  - Transaction history 
  - Topup balance 
  - Tranfer balance 