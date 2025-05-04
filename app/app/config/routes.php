<?php
/** @var Core\Router $router */

$router->add('GET', '/', 'AuthController@index');
$router->add('GET', '/register', 'AuthController@showRegisterForm');
$router->add('POST', '/register', 'AuthController@register');
$router->add('GET', '/login', 'AuthController@showLoginForm');
$router->add('GET', '/about', 'HomeController@about');
$router->add('GET', '/users', 'UserController@index');
$router->add('POST', '/users', 'UserController@store');
$router->add('GET', '/users/{id}', 'UserController@show');