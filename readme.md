# Easy Ordering System 2019 DB project
## This is based on Laravel 5.8 framework

System requirements:
 - PHP>=7.1
 - Composer>=1.6
 - Apache Version>=2.4

**For Windows:** If you have older version of PHP, remember to set your system environment change the PHP version to the latest or else you will not be able to finish the following steps below.

**For Mac:** I'm not so sure, cause I had the latest version at the start.

If you are pulling remember to run through the commands below

1. Open terminal in your folder and use either of the commands
```
composer update 
```
  or
```
composer install 
```
2. then
```
cp .env.example .env
php artisan key:generate

```
The env file is copied due to ```.gitignore``` will ignores it.
And you have to generate key to start the laravel. 
See more docs on [Laravel](https://laravel.com/docs/5.8).
