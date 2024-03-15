<?php

use App\Controllers\ErrorController;


define('base_url', __DIR__ . DIRECTORY_SEPARATOR);
include base_url . 'lib/config/Paths.php';
include base_url . 'app/config/Paths.php';
define('assets_url', app_url . 'assets' . DIRECTORY_SEPARATOR);

include lib_url . 'common.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', get_log_file_name());

include app_cfg_url . 'Database.php';
include lib_url . 'database' . DIRECTORY_SEPARATOR . 'Database.php';

include lib_sys_url . 'router/Routes.php';
$routes = new Lib\Systems\Router\Routes();
include app_cfg_url . 'Routes.php';

include lib_sys_url . 'router/Permits.php';
$permits = new Lib\Systems\Router\Permits;
include app_cfg_url . 'Permits.php';

foreach (glob(lib_models_url . '*.php') as $filename) {
    include_once $filename;
}
foreach (glob(app_models_url . '*.php') as $filename) {
    include_once $filename;
}

foreach (glob(lib_controllers_url . '*.php') as $filename) {
    include_once $filename;
}
foreach (glob(app_controllers_url . '*.php') as $filename) {
    include_once $filename;
}

log_nlcr();

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

$match = $routes->match($request_method, $request_uri);
if ($match === null) {
    goto not_found;
}

if (!$permits->check($request_uri, $request_method)) {
    $log_message = "403 - Forbidden";
    $log_message .= "\n\t\tRequest: $request_uri";
    $log_message .= "\n\t\tUri: " . base_url(preg_replace('/\//', '', $request_uri, 1));
    if ($request_method === 'GET' && count($_GET))
        $log_message .= "\n\t\tGet-Params-Count " . count($_GET);
    if ($request_method === 'POST' && count($_POST))
        $log_message .= "\n\t\tPost-Params-Count " . count($_POST);
    log_error($log_message);
    (new ErrorController($_GET, $_POST))->forbidden();
    goto end;
}

$callback = $match['match'];
$params = $match['params'];
if ($callback === null) {
    goto not_found;
}

list($controller, $method) = explode('::', $callback);
$controller_path = app_controllers_url . $controller . '.php';
include_once $controller_path;
$controller = "App\\Controllers\\$controller";
$controller_instance = new $controller($_GET, $_POST);


$log_message = "serving '$request_uri'";
$log_message .= "\n\t\tUri: " . base_url(preg_replace('/\//', '', $request_uri, 1));
$log_message .= "\n\t\tRequest-Method: '$request_method'";
$log_message .= "\n\t\tController: '$controller'";
$log_message .= "\n\t\tController-Method: '$method'";
$log_message .= "\n\t\tFile: file:///" . realpath($controller_path);
if ($request_method === 'GET' && count($_GET))
    $log_message .= "\n\t\tGet-Params-Count " . count($_GET);
if ($request_method === 'POST' && count($_POST))
    $log_message .= "\n\t\tPost-Params-Count " . count($_POST);
log_info($log_message);

try {
    echo $controller_instance->$method($params);
} catch (\Throwable $th) {
    if ($request_method === 'GET') {
        (new ErrorController(['error' => $th, ...$_GET], $_POST))->error();
    }
}
goto end;

not_found:
$log_message = "404 - Not Found";
$log_message .= "\n\t\tRequest: $request_uri";
$log_message .= "\n\t\tUri: " . base_url(preg_replace('/\//', '', $request_uri, 1));
if ($request_method === 'GET' && count($_GET))
    $log_message .= "\n\t\tGet-Params-Count " . count($_GET);
if ($request_method === 'POST' && count($_POST))
    $log_message .= "\n\t\tPost-Params-Count " . count($_POST);
log_error($log_message);
(new ErrorController($_GET, $_POST))->not_found();

end:
