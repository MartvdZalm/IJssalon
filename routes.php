<?php

$routes = array(
    '/' => 'OrderController@index',
    '/about' => 'AboutController@index',
    '/account' => 'AccountController@index',
    '/contact' => 'HomeController@index',
    '/cart' => 'CartController@index',
    '/register' => 'RegisterController@index',
    '/login' => 'LoginController@index',
    '/logout' => 'LoginController@logout',
    '/product/{id}' => 'ProductController@index',

    '/api/cart' => 'ApiController@cart',
);
