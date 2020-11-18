## Question App ##

**Question App** is a management system project with Laravel to manage classroom test or exam questions.

### Installation ###

* run `git clone https://github.com/JustCabyr/questionapp.git projectname` to clone the repository 
* run `cd projectname`
* run `composer install`
* copy *.env.example* to *.env*
* run `php artisan key:generate`to generate secure key in *.env* file
* if you use MySQL in *.env* file :
   * set DB_CONNECTION
   * set DB_DATABASE
   * set DB_USERNAME
   * set DB_PASSWORD
* if you use sqlite :
   * run `touch database/database.sqlite` to create the file
* run `php artisan migrate --seed` to create and populate tables
* run `php artisan passport:keys` to generate encryption keys
* run `npm install`

### API & Routes ###
Use the [Postman Collection link](https://www.getpostman.com/collections/d2bf711b986e1ea30cc7) to access the application APIs and routes

### Include ###

* [Laravel/Passport](https://laravel.com/docs/8.x/passport) and [JWT](https://jwt.io/introduction/) for Authentication
* [Docker](https://www.docker.com/) for containerization


### Tricks ###

To use application the database is seeding with users :

* Administrator : email = admin@admin.com, password = password

### Tests ###

When you want to launch the tests refresh and populate the database :

`php artisan migrate:fresh --seed`

### License ###

This example for Laravel is open-sourced software licensed under the MIT license
