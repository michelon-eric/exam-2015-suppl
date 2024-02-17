<?php

if (!function_exists('view')) {
    include lib_views_directory . 'View.php';
    function view(string $name, array $data = [])
    {
        // extract($data);
        // include app_views_directory . "$name.php";

        // return (new \Lib\Systems\Views\View($name, $data))->render();

        $data['view'] = $name;
        return (new \Lib\Systems\Views\View('layout/page', $data))->render();
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
