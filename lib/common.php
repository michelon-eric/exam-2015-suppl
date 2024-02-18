<?php

if (!function_exists('view')) {
    include lib_views_directory . 'View.php';
    function view(string $name, array $data = [])
    {
        // extract($data);
        // include app_views_directory . "$name.php";

        $view = new \Lib\Systems\Views\View($name, $data);

        // check for changes in the layout name when extending
        loop_start:
        $prev_name = $view->get_name();
        $view->render();
        if ($view->get_name() !== $prev_name) {
            goto loop_start;
        }

        // $data['view'] = $name;
        // return (new \Lib\Systems\Views\View('layout/page', $data))->render();
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
