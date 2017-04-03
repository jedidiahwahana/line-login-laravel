<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Deploying to Heroku

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

- In order to run this app, you need composer and laravel on your machine. Installation can be found [here for composer](https://getcomposer.org/download/) and [here for laravel](https://laravel.com/docs/5.1/installation#environment-configuration)
- Configure your Environment Variable:
	- LINE\_CHANNEL\_ID = Your Channel ID from [LINE Developers](developers.line.me)
	- LINE\_CHANNEL\_SECRET = Your Channel Secret from [LINE Developers](developers.line.me)
	- LINE\_CALLBACK\_URL = Your Callback URL which registered at [LINE Developers](developers.line.me)
	- BUILDPACK_URL = `https://github.com/heroku/heroku-buildpack-php`
	- APP_KEY
		- `$ php artisan key:generate`
		- copy and paste your key, start from **base64:**
	
