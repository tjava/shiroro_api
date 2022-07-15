<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('api/login', ['controller' => 'Login', 'action' => 'create']);
$router->add('api/signup', ['controller' => 'Signup', 'action' => 'create']);
$router->add('api/logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
// $router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('api/iot/create', ['controller' => 'Iot', 'action' => 'create']);
$router->add('api/iot/get', ['controller' => 'Iot', 'action' => 'get']);
$router->add('api/iot/update/{id:[a-zA-Z0-9.,_-]+}', ['controller' => 'Iot', 'action' => 'update']);
$router->add('api/iot/data', ['controller' => 'Iot', 'action' => 'data']);
$router->add('api/profile', ['controller' => 'Profile', 'action' => 'show']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);