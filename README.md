<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Application

Main purpose of this application is to create a platform where users can discuss top cryptos on CoinGecko website.
Users can create blogs, answer blogs and attach specified cryptos and its latest data. Application only lists top 5
crypto currency and if there are any changes in the top list new currencies will be added. It creates historical data 
every 10 minutes.

## Installation

1 => Download project and open its folder in terminal, you can then type php artisan serve in the root file.

2 => you are going to need any mysql connection, if you have xampp its fine, you can migrate the database.

3 => seed the database, php artisan db:seed --class=CryptoSeeder. This will add the first historical data to the database.

4 => You need to call schedules so it can create historical data every ten minutes, type php artisan schedule:work.


## Notes

1 => Users may have admin statue so they can call admin routes and perform more actions than any user.

2 => Third party API used in this project, it has no auth, free tier used.

3 => You can attach Cryptos to your blog post. Updating later is not allowed.

4 => You will need to create account and change its is_admin statue 0 to 1 if you want to access admin routes.

5 => You need auth key, do not forget to login first. You are gonna need to send this key to every request, or you can't access any route.



## Postman

https://documenter.getpostman.com/view/28032516/2s946cha27
