<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Load config file
require_once('config.php');

// Load composer file
require_once(DIR_VENDOR . 'autoload.php');

// Get all the available routes
require_once('routes.php');

// get the current URL path
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_path = str_replace(DIR_ROOTFOLDER, '', $url_path);

// check if the requested URL matches a route pattern that contains a parameter
$route_matched = false;
foreach ($routes as $route => $controller_action) {
    // check if the route contains a parameter
    if (strpos($route, '{') !== false) {
        // replace the parameter with a regular expression that matches any value
        $pattern = str_replace('{id}', '(\d+)', $route);
        // check if the URL matches the pattern
        if (preg_match("#^$pattern$#", $url_path, $matches)) {
            // extract the parameter value from the URL
            $id = $matches[1];
            // split the controller and action using the "@" symbol
            list($controller, $action) = explode('@', $controller_action);
            // create a new instance of the controller and call the action method with the parameter value
            $className = "Controllers\\$controller"; 
            $controller_obj = new $className(); 
            $controller_obj->$action($id);
            $route_matched = true;
            break;
        }
    } elseif ($url_path === $route) {
        // split the controller and action using the "@" symbol
        list($controller, $action) = explode('@', $controller_action);
        // create a new instance of the controller and call the action method
        $className = "Controllers\\$controller"; 
        $controller_obj = new $className(); 
        $controller_obj->$action();
        $route_matched = true;
        break;
    }
}

if (!$route_matched) {
    // handle 404 error
    header('Location: '. HTTP_SERVER .'error.html');
}


