# About Scandiweb_Test_Assignment

Scandiweb Test Assignment is a simple 2 page application designed with PHP as backend API and REACT as frontend.
The App folder contains the backend PHP codes and the public folder contains the frontend REACT codes.

## How to Install

Clone the application or download it in your local file and put it in your desired environment (XAMPP, WAMPP, LAMPP);

- Create a MYSQL database.
- Copy .env.example into .env.
- Change the .env file database parameters according to your database. As well as add your APP_URL without the http://.
- CD to the directory and run the following commands to install dependencies:

```php
composer install
composer dump-autoload
```

- Serve the PHP project with the bellow command:

```php
php -S localhost:8000
```

- CD to public directory and run the bellow commands:

```npm
npm install
npm start
```

and visit URL: <http://localhost:3000>

## Working Example

Visit: https://scandiweb.arzhang.xyz/ 

## Troubleshooting

- In case the react app didn't load data, please make sure to check api.js at public/src/services to make sure it is pointing to the correct api address.
- Please make sure to add your APP_URL at .env without "http://"
