# FORMUM 2019 [![Build Status](https://travis-ci.org/letz0703/forum2019.svg?branch=master)](https://travis-ci.org/letz0703/forum2019)

LARAVEL FORUM TEST

## Installation
### Prerequisites
> To run this project, you must have PHP 7 installed.
> You should setup a host on your web server for your local domain. For this you could also
> Configure Laravel Homestead or Valet(MAC only) 

### Step 1. 
Begin by cloning this repository to your machine, and Installing all Composer dependencies.

```bash
git clone git@github.com:letz0703/forum2019.git
cd forum2019 && composer install && npm install
php artisan key:generate
mv .env.example .env
npm run dev
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
> 1. Use your forum! Visit http://forum2019.test/register and register a account.
> 1. Edit `config/concil.php`, adding the email address of your account you just create.
> 1. Vist: `http://forum2019.test/admin/channels` to seed your forum with one or more channels.
