<?php

namespace Lib;

class CacheHandler
{
    private static $instance;
    private static $cache_path;

    private function __construct()
    {
        CacheHandler::$cache_path = app_url . '/.cache/';
        if (!is_dir(CacheHandler::$cache_path)) {
            mkdir(CacheHandler::$cache_path, 0777, true);
        }
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set($key, $value, $ttl = 3600)
    {
        $file_path = $this->get_cache_file_path($key);

        $data = [
            'value' => $value,
            'ttl' => time() + $ttl,
        ];

        file_put_contents($file_path, serialize($data));
    }

    public function get($key, $default = null)
    {
        $file_path = $this->get_cache_file_path($key);

        if (file_exists($file_path)) {
            $data = unserialize(file_get_contents($file_path));

            if ($data['ttl'] > time()) {
                return $data['value'];
            } else {
                unlink($file_path);
            }
        }

        return $default;
    }

    public function remove($key)
    {
        $filePath = $this->get_cache_file_path($key);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function clear()
    {
        $files = glob(CacheHandler::$cache_path . '*');

        foreach ($files as $file) {
            unlink($file);
        }
    }

    private function get_cache_file_path($key)
    {
        return CacheHandler::$cache_path . md5($key);
    }
}
