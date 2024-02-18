<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('base_url', __DIR__ . DIRECTORY_SEPARATOR);
include base_url . 'lib/config/Paths.php';
include base_url . 'app/config/Paths.php';
define('assets_url', app_url . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR);

include app_cfg_url . 'Database.php';

include lib_sys_url . 'router/Routes.php';
$routes = new Lib\Systems\Router\Routes();
include app_cfg_url . 'Routes.php';

include lib_url . 'common.php';


$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$callback = $routes->match($request_method, $request_uri);

if ($callback === null) {
    view('errors/404');
} else {
    list($controller, $method) = explode('::', $callback);
    include 'app/controllers/' . $controller . '.php';
    $controller = "App\\Controllers\\$controller";
    $controller_instance = new $controller($_GET, $_POST);
    echo $controller_instance->$method();
}
