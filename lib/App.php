<?php

namespace Lib;

use App\Controllers\ErrorController;
use Lib\Systems\Router;
use Lib\Systems\Controllers;
use Lib\Systems\Models;
use Lib\Systems\Router\Routes;
use Lib\Systems\Router\Permits;
use Lib\Systems\Views;
use Lib\Request;

class App {
    protected $start_time;

    protected Request $request;

    protected Permits $permits;
    protected Routes $router;

    public function initialize(): void {
        $this->start_time = microtime(true);

        include lib_sys_url . 'router/Routes.php';
        $routes = new Routes();
        include app_cfg_url . 'Routes.php';
        $this->router = $routes;

        include lib_sys_url . 'router/Permits.php';
        $permits = new Permits();
        include app_cfg_url . 'Permits.php';
        $this->permits = $permits;

        include app_cfg_url . 'Database.php';
        include lib_url . 'database' . DIRECTORY_SEPARATOR . 'Database.php';

        foreach (glob(lib_models_url . '*.php') as $filename) {
            include_once $filename;
        }
        foreach (glob(app_models_url . '*.php') as $filename) {
            include_once $filename;
        }

        foreach (glob(lib_controllers_url . '*.php') as $filename) {
            include_once $filename;
        }

        include app_controllers_url . 'ErrorController.php';

        log_nlcr();
    }

    public function run(): void {
        $request_method = $_SERVER['REQUEST_METHOD'];
        $request_uri = $_SERVER['REQUEST_URI'];

        $this->prepare_request();

        $match = $this->router->match($request_method, $request_uri);
        if ($match === null) {
            $this->not_found($request_uri, $request_method);
            return;
        }

        if (!$this->permits->check($request_uri, $request_method)) {
            $this->forbidden($request_uri, $request_method);
            return;
        }

        $callback = $match['match'];
        $params = $match['params'];
        if ($callback === null) {
            $this->not_found($request_uri, $request_method);
            return;
        }

        [$controller, $method] = explode('::', $callback);
        $controller_path = app_controllers_url . $controller . '.php';
        include_once $controller_path;
        $controller = "App\\Controllers\\$controller";
        $controller_instance = new $controller($_GET, $_POST);

        $this->log_request($request_uri, $request_method, $controller, $method, $controller_path);

        try {
            echo $controller_instance->$method($params);
        } catch (\Throwable $th) {
            $this->error($request_method, $th);
        }
    }

    protected function forbidden(string $request_uri, string $request_method): void {
        $log_message = '403 - Forbidden';
        $log_message .= "\n\t\tRequest: $request_uri";
        $log_message .= "\n\t\tUri: " . base_url(preg_replace('/\//', '', $request_uri, 1));
        if ($request_method === 'GET' && count($_GET)) {
            $log_message .= "\n\t\tGet-Params-Count " . count($_GET);
        }
        if ($request_method === 'POST' && count($_POST)) {
            $log_message .= "\n\t\tPost-Params-Count " . count($_POST);
        }
        log_error($log_message);
        (new ErrorController($_GET, $_POST))->forbidden();
    }

    protected function log_request(string $request_uri, string $request_method, string $controller, string $method, string $controller_path): void {
        $log_message = "serving '$request_uri'";
        if (isset ($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true')
            $log_message .= "\n\t\tHTMX-Request";
        $log_message .= "\n\t\tUri: " . base_url(preg_replace('/\//', '', $request_uri, 1));
        $log_message .= "\n\t\tRequest-Method: '$request_method'";
        $log_message .= "\n\t\tController: '$controller'";
        $log_message .= "\n\t\tController-Method: '$method'";
        $log_message .= "\n\t\tFile: file:///" . realpath($controller_path);
        if ($request_method === 'GET' && count($_GET)) {
            $log_message .= "\n\t\tGet-Params-Count " . count($_GET);
        }
        if ($request_method === 'POST' && count($_POST)) {
            $log_message .= "\n\t\tPost-Params-Count " . count($_POST);
        }
        log_info($log_message);
    }

    protected function not_found(string $request_uri, string $request_method): void {
        $log_message = '404 - Not Found';
        $log_message .= "\n\t\tRequest: $request_uri";
        $log_message .= "\n\t\tUri: " . base_url(preg_replace('/\//', '', $request_uri, 1));
        if ($request_method === 'GET' && count($_GET)) {
            $log_message .= "\n\t\tGet-Params-Count " . count($_GET);
        }
        if ($request_method === 'POST' && count($_POST)) {
            $log_message .= "\n\t\tPost-Params-Count " . count($_POST);
        }
        log_error($log_message);
        (new ErrorController($_GET, $_POST))->not_found();
    }

    protected function error(string $request_method, \Throwable $th): void {
        log_error($th);
        if ($request_method === 'GET') {
            (new ErrorController(['error' => $th, ...$this->request->get_params()], $this->request->post_params()))->error();
        }
    }

    protected function prepare_request(): void {
        $this->request = new Request($_GET, $_POST);
    }
}
