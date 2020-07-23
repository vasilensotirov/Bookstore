<?php

use router\Router;
use components\router\http\Request;
use components\Authenticator;

$router = new Router(new Request(), new Authenticator());

$router->route('/view/main', 'BooksController@getAll', true);
$router->route('/user/login', 'UserController@login');
$router->route('/user/register', 'UserController@register');
$router->route('/user/logout', 'UserController@logout', true);
$router->route('/book/create', 'BooksController@create', true);
$router->route('/book/delete/{id}', 'BooksController@delete', true);
$router->route('/book/edit/{id}', 'BooksController@loadEdit', true);
$router->route('/book/edit', 'BooksController@edit', true);
$router->route('/book/{id}', 'BooksController@getById', true);
$router->route('/view/login', 'ViewController@viewRouter');
$router->route('/view/register', 'ViewController@viewRouter');
$router->route('/view/editProfile', 'ViewController@viewRouter');
$router->route('/view/create', 'ViewController@viewRouter');
$router->route('/view/createPlaylist', 'ViewController@viewRouter');
$router->route('/view/editProfile', 'ViewController@viewRouter', true);
$router->route('/user/edit', 'UserController@edit', true);
