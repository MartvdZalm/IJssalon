<?php

$routes = array(

    // Webshop
    '/' => 'ShopController@index',
    '/about' => 'AboutController@index',
    '/account' => 'AccountController@index',
    '/account/order/{id}' => 'AccountController@order',
    '/contact' => 'HomeController@index',
    '/cart' => 'CartController@index',
    '/register' => 'RegisterController@index',
    '/login' => 'LoginController@index',
    '/logout' => 'LoginController@logout',
    '/product/{id}' => 'ProductController@index',
    '/message/order' => 'MessageController@order',
    '/message/account' => 'MessageController@account',

    // Api 
    '/api/cart' => 'ApiController@cart',
    '/api/makeOrder' => 'ApiController@makeOrder',
    '/api/remove/user' => 'ApiController@removeUser',


    // Admin panel
    '/50249/admin/' => 'AdminController@dashboard',
    '/50249/admin/users' => 'AdminController@users',
    '/50249/admin/users/{id}' => 'AdminController@user',
    '/50249/admin/producten' => 'AdminController@producten',
    '/50249/admin/producten/{id}' => 'AdminController@product',
    '/50249/admin/producten/add' => 'AdminController@productAdd',
    '/50249/admin/orders' => 'AdminController@orders',
    '/50249/admin/orders/{id}' => 'AdminController@order',  
);
