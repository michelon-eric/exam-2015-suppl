<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('base_url', __DIR__ . DIRECTORY_SEPARATOR);
include base_url . 'lib/config/Paths.php';
include base_url . 'app/config/Paths.php';
define('assets_url', app_url . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR);

include app_cfg_url . 'Database.php';
include lib_url . 'database' . DIRECTORY_SEPARATOR . 'Database.php';

include lib_sys_url . 'router/Routes.php';
$routes = new Lib\Systems\Router\Routes();
include app_cfg_url . 'Routes.php';

include lib_url . 'common.php';

foreach (glob("Lib/systems/models/*.php") as $filename) {
    include_once $filename;
}
foreach (glob("App/models/*.php") as $filename) {
    include_once $filename;
}

foreach (glob("Lib/systems/controllers/*.php") as $filename) {
    include_once $filename;
}
foreach (glob("App/controllers/*.php") as $filename) {
    include_once $filename;
}


$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$match = $routes->match($request_method, $request_uri);
if ($match === null) {
    goto not_found;
}

$callback = $match['match'];
$params = $match['params'];
if ($callback === null) {
    goto not_found;
}

list($controller, $method) = explode('::', $callback);
include_once 'app/controllers/' . $controller . '.php';
$controller = "App\\Controllers\\$controller";
// log_info('serving ' . $controller);
$controller_instance = new $controller($_GET, $_POST);
try {
    echo $controller_instance->$method($params);
} catch (\Exception $e) {
    log_error($e);
    if ($request_method === 'get')
        view('errors/error', ['error' => $e]);
}
goto end;

not_found:
view('errors/404');

end:
