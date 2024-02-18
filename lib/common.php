<?php

if (!function_exists('view')) {
    include lib_views_url . 'View.php';
    function view(string $name, array $data = [])
    {
        // extract($data);
        // include app_views_url . "$name.php";

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
    include lib_url . 'SessionHandler.php';

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

if (!function_exists('assets_path')) {
    function assets_path($url)
    {
        $app_path = app_assets_url . $url;
        if (!file_exists($app_path)) {
            $lib_path = lib_assets_url . $url;
            if (!file_exists($lib_path)) {
                return $url;
            } {
                $path = $lib_path;
            }
        } else {
            $path = $app_path;
        }

        return str_replace(base_url, '', $path);
    }
}
