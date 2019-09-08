# FORMUM 2019 [![Build Status](https://travis-ci.org/letz0703/forum2019.svg?branch=master)](https://travis-ci.org/letz0703/forum2019)

LARAVEL FORUM TEST

## Installation
### Step 1. 
> To run this project, you must have PHP 7 installed as prerequisite.

Begin by cloning this repository to your machine, and Installing all Composer dependencies.

```bash
git clone git@github.com:letz0703/forum2019.git
cd forum2019 && composer install
php artisan key:generate
mv .env.example .env
```

### Step 2.
> Next, create new database and reference its name and username/password within this projects .env file.
```
    Example goes here
```

### Step 3.
> reCAPTCHA is a google tool to help prevent forum from spam. You'll need to crate free account.
https://www.google.com/recaptcha/intro

### Step 4.
> Until an administration portal is available, manually insert any number of "channels" into the channels table 
 in your database. Once finished, clear your server cache, and you'll all set to go.
 ```
php artisan cache:clear
 ```
 ### Step 5.
 > Use your forum! Visit http://forum2019.test/threads
