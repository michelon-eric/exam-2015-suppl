<?php

namespace Lib;

class SessionHandler
{
    private static $instance;

    private function __construct()
    {
        session_start();
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy()
    {
        session_destroy();
    }

    public function regenerate()
    {
        session_regenerate_id(true);
    }
}
