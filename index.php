<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load config file
require_once('config.php');

// Load composer file
require_once(DIR_VENDOR . 'autoload.php');

// Get all the available routes
require_once('routes.php');

// get the current URL path
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_path = str_replace(DIR_ROOTFOLDER, '', $url_path);

// match the route to a controller action
if (array_key_exists($url_path, $routes)) {
    $controller_action = $routes[$url_path];
    
    // split the controller and action using the "@" symbol
    list($controller, $action) = explode('@', $controller_action);

    // create a new instance of the controller and call the action method
    $className = "Controllers\\$controller"; 
    $controller_obj = new $className(); 

    $controller_obj->$action();
} else {
    // handle 404 error
    header('Location: '. HTTP_SERVER .'error.html');
}

