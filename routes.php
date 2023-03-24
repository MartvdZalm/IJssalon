<?php

$routes = array(
    '/' => 'OrderController@index',
    '/blog' => 'HomeController@index',
    '/about' => 'AboutController@index',
    '/contact' => 'HomeController@index',
    '/cart' => 'HomeController@index',
    '/register' => 'RegisterController@index',
    '/login' => 'LoginController@index',
    '/logout' => 'LoginController@logout',
    '/product/{id}' => 'ProductController@index',
);
