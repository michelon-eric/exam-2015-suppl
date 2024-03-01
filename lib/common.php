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

if (!function_exists('cache')) {
    include lib_url . 'CacheHandler.php';

    function cache()
    {
        return Lib\CacheHandler::get_instance();
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

if (!function_exists('base_url')) {
    function base_url($url = '')
    {
        $base_url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . '/';
        return $base_url . $url;
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($input)
    {
        if (is_array($input)) {
            return array_map('sanitize_input', $input);
        } else {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
    }
}

if (!function_exists('set_flash_message') && !function_exists('get_flash_message')) {
    function set_flash_message($key, $message)
    {
        session()->set($key, $message);
    }

    function get_flash_message($key)
    {
        $message = session()->get($key, null);
        session()->remove($key);
        return $message;
    }
}

if (!function_exists('json_response')) {
    function json_response($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('generate_csrf_token') && !function_exists('verify_csrf_token')) {
    function generate_csrf_token()
    {
        $token = bin2hex(random_bytes(32));
        session()->set('csrf-token', $token);
        return $token;
    }

    function verify_csrf_token($token)
    {
        return session()->get('csrf-token', false) && session()->get('csrf-token') === $token;
    }
}

if (!function_exists('log_error') && !function_exists('log_info')) {
    function log_error($message)
    {
        $log_file = app_url . '/.logs/logs.log';
        create_log_file_if_not_exists($log_file);
        error_log("[ERROR] " . date('Y-m-d H:i:s') . ": " . $message . PHP_EOL, 3, $log_file);
    }

    function log_info($message)
    {
        $log_file = app_url . '/.logs/logs.log';
        create_log_file_if_not_exists($log_file);
        error_log("[INFO] " . date('Y-m-d H:i:s') . ": " . $message . PHP_EOL, 3, $log_file);
    }

    function create_log_file_if_not_exists($log_file)
    {
        if (!file_exists($log_file)) {
            $log_directory = dirname($log_file);
            if (!is_dir($log_directory)) {
                mkdir($log_directory, 0777, true);
            }
            touch($log_file);
        }
    }
}
