<?php
/** @var Core\Router $router */

$router->add('GET', '/', 'AuthController@index');
$router->add('GET', '/register', 'AuthController@showRegisterForm');
$router->add('POST', '/register', 'AuthController@register');
$router->add('GET', '/login', 'AuthController@showLoginForm');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/dashboard', 'HomeController@dashboard');
$router->add('GET', '/ticket', 'HomeController@ticketForm');
$router->add('POST', '/ticket', 'HomeController@ticketStore');
$router->add('GET', '/ticket/list', 'HomeController@showTicketList');
$router->add('GET', '/admin/ticket/lists', 'HomeController@allTicketLists');
$router->add('GET', '/admin/ticket/list/{id}', 'HomeController@showTicketDetailsAdmin');
$router->add('POST', '/ticket/assign', 'HomeController@ticketAssign');


$router->add('GET', '/agent/ticket/lists', 'AgentController@agentTicketLists');
$router->add('GET', '/agent/ticket/list/{id}', 'AgentController@showTicketDetailsAgent');
$router->add('POST', '/ticket/reply', 'AgentController@ticketReply');



$router->add('GET', '/logout', 'AuthController@logout');
$router->add('GET', '/users', 'UserController@index');
$router->add('POST', '/users', 'UserController@store');
$router->add('GET', '/users/{id}', 'UserController@show');
