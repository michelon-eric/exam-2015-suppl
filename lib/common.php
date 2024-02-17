<?php

use Lib\Systems\Views\View;

if (!function_exists('view')) {
    include lib_views_directory . 'View.php';
    function view(string $name, array $data = [])
    {
        $view = new View($name);

        foreach ($data as $key => $value) {
            $view->with($key, $value);
        }

        $view->render();

        // include app_views_directory . "$name.php";
    }
}

if (!function_exists('session')) {
    include lib_directory . 'SessionHandler.php';

    function session()
    {
        return Lib\SessionHandler::get_instance();
    }
}

if (!function_exists('redirect')) {
    function redirect($url, $statusCode = 302)
    {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }
}
