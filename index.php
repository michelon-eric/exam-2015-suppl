<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('main_directory', __DIR__ . DIRECTORY_SEPARATOR);
include main_directory . 'lib/config/Paths.php';
include main_directory . 'app/config/Paths.php';

include app_config_directory . 'Database.php';

include lib_systems_directory . 'router/Routes.php';
$routes = new Lib\Systems\Router\Routes();
include app_config_directory . 'Routes.php';

include lib_directory . 'common.php';

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
    $controller_instance->$method();
}
