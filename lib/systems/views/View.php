<?php

namespace Lib\Systems\Views;

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
        if ($this->data !== null) extract($this->data);

        $file_path = app_views_directory . "{$this->name}.php";

        if (!file_exists($file_path)) {
            redirect('404');
        }

        include app_views_directory . "{$this->name}.php";
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
        $view = new View($layout, $this->data);
        $view->sections = $this->sections;
        $view->render();
    }

    public function include($layout)
    {
        $view = new View($layout, $this->data);
        $view->render();
    }
}
