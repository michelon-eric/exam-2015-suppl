<?php

namespace Lib\Systems\Router;

class Permits
{
    protected $permissions = [];

    public function add($route, callable $callback)
    {
        $this->permissions[$route] = $callback;
    }

    public function check($route, $method): bool
    {
        if (!isset($this->permissions[$route])) {
            return true;
        }

        $callback = $this->permissions[$route];
        return $callback($route, $method) ?? false;
    }
}
