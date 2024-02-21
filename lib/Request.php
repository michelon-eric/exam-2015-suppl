<?php

namespace Lib;

class Request
{
    protected $get_params;
    protected $post_params;

    public function __construct($get_params, $post_params)
    {
        $this->get_params = $get_params;
        $this->post_params = $post_params;
    }

    public function get_get($key, $default = null)
    {
        return $this->get_params[$key] ?? $default;
    }

    public function get_post($key, $default = null)
    {
        return $this->post_params[$key] ?? $default;
    }

    public function get_params()
    {
        return $this->get_params;
    }

    public function post_params()
    {
        return $this->post_params;
    }
}
