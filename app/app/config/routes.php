<?php
/** @var Core\Router $router */

$router->add('GET', '/register', 'RegisterController@index');
$router->add('GET', '/about', 'HomeController@about');
$router->add('GET', '/users', 'UserController@index');
$router->add('POST', '/users', 'UserController@store');
$router->add('GET', '/users/{id}', 'UserController@show');