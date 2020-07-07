## Mini E-wallet
RESTAPI Mini Ewallet implementation build with PHP Laravel 

## Documentation 
Via [Swaggerhub](https://app.swaggerhub.com/apis-docs/hellodit/mini-ewallet/1.0.0-oas3#/)

## How to run to your local
- Clone this repository `https://github.com/hellodit/mini-ewallet`
- Create MySQL database table
- Rename .env.example file to .env inside your project root and fill the database information.
- Open the console and cd your project root directory
- Run `composer install `or php composer.phar install
- Run `php artisan key:generate`
- Run `php artisan migrate`
- Run `php artisan db:seed` to run seeders
- Run `php artisan serve`
- You can now access your project at `localhost:8000` :)