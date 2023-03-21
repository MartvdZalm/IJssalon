<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('config.php');
require_once('routes.php');
require_once(DIR_VENDOR . 'autoload.php');

// get the current URL path
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// match the route to a controller action
if (array_key_exists($url_path, $routes)) {
    $controller_action = $routes[$url_path];
    
    // split the controller and action using the "@" symbol
    list($controller, $action) = explode('@', $controller_action);
    
    // include the controller file
    require_once(DIR_CONTROLLER. $controller . '.php');
    
    // create a new instance of the controller and call the action method
    $controller_obj = new $controller();
    $controller_obj->$action();
} else {
    // handle 404 error
    echo "Hello there";
}

