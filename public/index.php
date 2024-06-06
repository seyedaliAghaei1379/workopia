<?php
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;
use Framework\Session;

Session::start();

require '../helpers.php';

//session_start();




//use Framework\Database;


//session_destroy();
//inspectAndDie(session_status());

//spl_autoload_register(function ($class){
//    $path = basePath('Framework/' . $class . '.php');
//    if(file_exists($path)){
//        require $path;
//    }
//});


// Instantiating the router
$router = new Router();

// Get routes
$routes = require basePath('routes.php');

//Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'] , PHP_URL_PATH);
//inspectAndDie($uri);


// Route the request
$router->route($uri);



