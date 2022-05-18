<?php
require 'vendor/autoload.php';

use App\Routes;
use Dotenv\Dotenv;

//Loading DotEnv for environment variable
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Don't display errors if APP_ERRORS is false in .env
if ($_ENV['APP_ERRORS'] == 'false') {
    error_reporting(0);
}

//Initiate routes
$api = new Routes();
$api->startHeaderAndRouter();

//Call specific controller based on the route name
$controller = new $api->routes[$api->request_route]($api->request, $api->id);
$controller->processRequest();
