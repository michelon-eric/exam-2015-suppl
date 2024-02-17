<?php

namespace Lib\Systems\Router;

class Routes
{
    private $routes = [];

    public function get($url, $callback)
    {
        $this->add_route('GET', $url, $callback);
    }

    public function post($url, $callback)
    {
        $this->add_route('POST', $url, $callback);
    }

    private function add_route($method, $url, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'callback' => $callback,
        ];
    }

    public function match($method, $url)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['url'] === $url) {
                return $route['callback'];
            }
        }

        return null;
    }
}
