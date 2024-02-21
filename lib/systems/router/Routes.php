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
        $urlParts = parse_url($url);
        $path = $urlParts['path'] ?? '';

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $pattern = $this->build_pattern($route['url']);

                // Ignore everything after '?'
                $pathWithoutQuery = strtok($path, '?');

                if (preg_match($pattern, $pathWithoutQuery, $matches)) {
                    $params = array_slice($matches, 1);
                    return ['match' => $route['callback'], 'params' => $params];
                }
            }
        }

        return null;
    }

    private function build_pattern($url)
    {
        $pattern = preg_replace('/\//', '\/', $url);
        $pattern = preg_replace('/\{[^\}]+\}/', '([^\/]+)', $pattern);
        return '/^' . $pattern . '$/';
    }
}
