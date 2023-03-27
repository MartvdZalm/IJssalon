<?php

$routes = array(
    '/' => 'ShopController@index',
    '/about' => 'AboutController@index',
    '/account' => 'AccountController@index',
    '/contact' => 'HomeController@index',
    '/cart' => 'CartController@index',
    '/register' => 'RegisterController@index',
    '/login' => 'LoginController@index',
    '/logout' => 'LoginController@logout',
    '/product/{id}' => 'ProductController@index',
    '/success/order' => 'SuccesController@order',

    '/api/cart' => 'ApiController@cart',
    '/api/makeOrder' => 'ApiController@makeOrder',
);
