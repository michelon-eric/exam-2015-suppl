<?php

namespace Lib;

class SessionHandler {
    private static $instance;

    private function __construct() {
        session_start();
        $_SESSION['__flash_vars__'] = [];
    }

    public static function get_instance(): SessionHandler {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_destroy();
    }

    public function regenerate() {
        session_regenerate_id(true);
    }

    public function set_flash_data($key, $value) {
        $_SESSION['__flash_vars__'][$key] = $value;
    }

    public function get_flash_data($key, $default = null): mixed {
        $value = $default;
        if ($this->is_set($key)) {
            $value = $_SESSION['__flash_vars__'][$key];
            unset($_SESSION['__flash_vars__'][$key]);
        }

        return $value;
    }

    public function is_set($key): bool {
        return isset ($_SESSION[$key]) || isset ($_SESSION['__flash_vars__'][$key]);
    }

    public function unset($key): bool {
        if (!$this->is_set($key)) {
            return false;
        }
        unset($_SESSION[$key]);
        return true;
    }
}
