<?php

namespace Lib\Systems\Views;

class View
{
    protected $data;
    protected $name;

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
}
