<?php

if (!function_exists('view')) {
    include lib_views_url . 'View.php';
    function view(string $name, array $data = []) {
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
    include_once lib_url . 'SessionHandler.php';

    function session(): Lib\SessionHandler {
        return Lib\SessionHandler::get_instance();
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, array $params = [], int $statusCode = 0) {
        $cmd = 'Location:';
        if (isset ($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] === 'true') {
            $url = base_url() . $url;
            $cmd = 'HX-Redirect:';
        }

        if (!empty ($params)) {
            $url .= '?' . http_build_query($params);
        }

        log_debug("redirect\n\t\tHeader: '$cmd'\n\t\tUrl: '$url'");
        header("$cmd $url", true, $statusCode);
        exit;
    }
}

if (!function_exists('assets_path')) {
    function assets_path($url = ''): string {
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

        return str_replace(base_url, '/', $path);
    }
}

if (!function_exists('base_url')) {
    function base_url($url = ''): string {
        $base_url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . '/';
        return "$base_url$url";
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($input): array|string {
        if (is_array($input)) {
            return array_map('sanitize_input', $input);
        } else {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
    }
}

if (!function_exists('set_flash_message') && !function_exists('get_flash_message')) {
    function set_flash_message($key, $message) {
        session()->set($key, $message);
    }

    function get_flash_message($key): mixed {
        $message = session()->get($key, null);
        session()->remove($key);
        return $message;
    }
}

if (!function_exists('json_response')) {
    function json_response($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('generate_csrf_token') && !function_exists('verify_csrf_token')) {
    function generate_csrf_token(): string {
        $token = bin2hex(random_bytes(32));
        session()->set('csrf-token', $token);
        return $token;
    }

    function verify_csrf_token($token): bool {
        return session()->get('csrf-token', false) && session()->get('csrf-token') === $token;
    }
}

if (!function_exists('log_error') && !function_exists('log_info') && !function_exists('log_warn') && !function_exists('log_nlcr') && !function_exists('log_debug')) {
    function log_nlcr() {
        $log_file = get_log_file_name();
        create_log_file_if_not_exists($log_file);
        error_log(PHP_EOL, 3, $log_file);
    }

    function log_error($message) {
        $log_file = get_log_file_name();
        create_log_file_if_not_exists($log_file);
        error_log("[ERROR] " . date('Y-m-d H:i:s') . ": " . $message . PHP_EOL, 3, $log_file);
    }

    function log_info($message) {
        $log_file = get_log_file_name();
        create_log_file_if_not_exists($log_file);
        error_log("[INFO] " . date('Y-m-d H:i:s') . ": " . $message . PHP_EOL, 3, $log_file);
    }

    function log_warn($message) {
        $log_file = get_log_file_name();
        create_log_file_if_not_exists($log_file);
        error_log("[WARN] " . date('Y-m-d H:i:s') . ": " . $message . PHP_EOL, 3, $log_file);
    }

    function log_debug($message) {
        $log_file = get_log_file_name();
        create_log_file_if_not_exists($log_file);
        error_log("[DEBUG] " . date('Y-m-d H:i:s') . ": " . $message . PHP_EOL, 3, $log_file);
    }

    function create_log_file_if_not_exists($log_file) {
        if (!file_exists($log_file)) {
            $log_directory = dirname($log_file);
            if (!is_dir($log_directory)) {
                mkdir($log_directory, 0777, true);
            }
            touch($log_file);
        }
    }

    function get_log_file_name() {
        return app_url . '.logs' . DIRECTORY_SEPARATOR . date('Y-m-d') . '_logs.log';
    }
}

if (!function_exists('chash')) {
    function chash(mixed $value, bool $binary = false): string {
        return md5($value, $binary);
    }

    function check_chash(string $hashed, string $value): bool {
        return chash($value) === $hashed;
    }
}

if (!function_exists('validate_password')) {
    function validate_password(string $password): bool {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])[A-Za-z\d\W]{8,}$/', $password);
    }
}

if (!function_exists('validate_email')) {
    function validate_email(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists('validate_phone')) {
    function validate_phone(string $phone): bool {
        return preg_match('/^\d{10}$/', $phone);
    }
}

if (!function_exists('validate_zip')) {
    function validate_zip(string $zip): bool {
        return preg_match('/^\d{5}$/', $zip);
    }
}

if (!function_exists('encrypt') && !function_exists('decrypt')) {
    define('app_enckey_url', app_cfg_url . 'encryption-key');
    define('app_cipher', 'aes-128-cbc');

    if (!file_exists(app_enckey_url)) {
        log_nlcr();
        $msg = 'Generating new openssl encryption key 128bit';
        $msg .= "\n\t\tUrl: " . app_enckey_url;
        log_info($msg);
        $key = openssl_random_pseudo_bytes(16);
        file_put_contents(app_enckey_url, $key);
    }

    function encrypt($data) {
        $key = file_get_contents(app_enckey_url);
        $ivlen = openssl_cipher_iv_length(app_cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $encrypted = openssl_encrypt($data, app_cipher, $key, $options = 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    function decrypt($data) {
        $key = file_get_contents(app_enckey_url);
        $data = base64_decode($data);
        list($encrypted_data, $iv) = explode('::', $data, 2);
        return openssl_decrypt($encrypted_data, app_cipher, $key, $options = 0, $iv);
    }
}

if (!function_exists('dbarray_to_object')) {
    function dbarray_to_object(array $array): object {
        $new_array = [];

        foreach ($array as $key => $value) {
            if (preg_match('/^[A-Z]{3}_/', $key)) {
                $key = substr($key, 4);
            }
            $key = preg_replace('/(?<=\\w)(?=[A-Z])/', "_", $key);
            $key = strtolower($key);
            $new_array[$key] = $value;
        }

        return (object) $new_array;
    }
}
