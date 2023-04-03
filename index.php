<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('config.php');
require_once(DIR_VENDOR . 'autoload.php');
require_once('routes.php');

$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_path = str_replace(DIR_ROOTFOLDER, '', $url_path);

$route_matched = false;
foreach ($routes as $route => $controller_action) {

    if (strpos($route, '{') !== false) {

        $pattern = str_replace('{id}', '(\d+)', $route);

        if (preg_match("#^$pattern$#", $url_path, $matches)) {

            $id = $matches[1];
            list($controller, $action) = explode('@', $controller_action);

            $className = "Controllers\\$controller"; 
            $controller_obj = new $className(); 
            $controller_obj->$action($id);
            $route_matched = true;
            break;
        }
    } elseif ($url_path === $route) {

        list($controller, $action) = explode('@', $controller_action);

        $className = "Controllers\\$controller"; 
        $controller_obj = new $className(); 
        $controller_obj->$action();
        $route_matched = true;
        break;
    }
}

if (!$route_matched) {
    // handle 404 error
    header('Location: '. HTTP_SERVER . '404');
}


