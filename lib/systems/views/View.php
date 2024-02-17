<?php

namespace Lib\Systems\Views;

class View
{
    protected $data;
    protected $sections = [];
    protected $layout;

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function extend($layout)
    {
        $view = new View($layout);
        $view->render();
        return $view;
    }

    public function section($name)
    {
        ob_start();
        $this->sections[$name] = true;

        return $this;
    }

    public function end_section()
    {
        if (empty($this->sections)) {
            throw new \RuntimeException("No section started.");
        }

        $last_section = array_key_last($this->sections);
        $this->sections[$last_section] = ob_get_clean();

        return $this;
    }

    public function render_section($name)
    {
        echo isset($this->sections[$name]) ? $this->sections[$name] : '';
    }

    public function include($view, $data = [])
    {
        $view_file = app_views_directory . "{$view}.php";

        if (file_exists($view_file)) {
            $view = new self($this->layout);
            $view->data = $data;
            include $view_file;
        } else {
            redirect('404');
        }
    }

    public function render()
    {
        if ($this->data !== null)
            extract($this->data);
        // echo app_views_directory . "{$this->layout}.php";
        include app_views_directory . "{$this->layout}.php";
    }
}
