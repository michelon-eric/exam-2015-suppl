<?php

namespace Lib\Systems\Views;

// probs the most inspired thing in this project

class View
{
    protected $data;
    protected $name;
    protected $sections = [];
    protected $section_stack = [];

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    public function render()
    {
        if ($this->data !== null)
            extract($this->data);

        $file_path = app_views_url . "{$this->name}.php";

        if (!file_exists($file_path)) {
            throw new \Exception("trying to render file $file_path that doesn't exist");
        }

        include app_views_url . "{$this->name}.php";
    }

    public function section($name)
    {
        $this->section_stack[] = $name;
        ob_start();
    }

    public function end_section()
    {
        $contents = ob_get_clean();

        if ($this->section_stack === []) {
            throw new \RuntimeException('View themes, no current section.');
        }

        $section = array_pop($this->section_stack);

        if (!array_key_exists($section, $this->sections)) {
            $this->sections[$section] = [];
        }

        $this->sections[$section][] = $contents;
    }

    public function render_section($name)
    {
        if (!isset($this->sections[$name])) {
            echo '';
            return;
        }

        foreach ($this->sections[$name] as $key => $contents) {
            echo $contents;
            unset($this->sections[$name][$key]);
        }
    }

    public function extend($layout)
    {
        // $view = new View($layout, $this->data);
        // $view->sections = $this->sections;
        // $view->render();

        $this->name = $layout;
    }

    public function include($layout)
    {
        $view = new View($layout, $this->data);
        $view->render();
    }

    public function get_name()
    {
        return $this->name;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->$name)
            ? $this->$name
            : $this->data[$name];
    }
}
