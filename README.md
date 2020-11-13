## Question App ##

**Question App** is a management system project with Laravel to manage classroom test or exam questions.

### Installation ###

* type `git clone https://github.com/JustCabyr/questionapp.git projectname` to clone the repository 
* type `cd projectname`
* type `composer install`
* type `composer update`
* copy *.env.example* to *.env*
* type `php artisan key:generate`to generate secure key in *.env* file
* if you use MySQL in *.env* file :
   * set DB_CONNECTION
   * set DB_DATABASE
   * set DB_USERNAME
   * set DB_PASSWORD
* if you use sqlite :
   * type `touch database/database.sqlite` to create the file
* type `php artisan migrate` to create and populate tables

### Tests ###

When you want to launch the tests refresh and populate the database :

`php artisan migrate:fresh --seed`

### License ###

This example for Laravel is open-sourced software licensed under the MIT license
