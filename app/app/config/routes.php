<?php
/** @var Core\Router $router */

$router->add('GET', '/', 'AuthController@index');
$router->add('GET', '/register', 'AuthController@showRegisterForm');
$router->add('POST', '/register', 'AuthController@register');
$router->add('GET', '/login', 'AuthController@showLoginForm');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/dashboard', 'HomeController@dashboard');
$router->add('GET', '/logout', 'AuthController@logout');
$router->add('GET', '/users', 'UserController@index');
$router->add('POST', '/users', 'UserController@store');
$router->add('GET', '/users/{id}', 'UserController@show');