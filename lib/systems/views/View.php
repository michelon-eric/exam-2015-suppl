<?php

namespace Lib\Systems\Views;

// probs the most inspired thing in this project

class View {
    protected $data;
    protected $name;
    protected $sections = [];
    protected $section_stack = [];

    protected $filters = [];

    public function __construct($name, $data) {
        $this->name = $name;
        $this->data = $data;

        $this->filters = [
            'uppercase' => 'strtoupper',
            'lowercase' => 'strtolower',
            'trim' => 'trim',
            'md5' => 'md5',
            'base64_encode' => 'base64_encode',
            'base64_decode' => 'base64_decode',
            'url_encode' => 'urlencode',
            'url_decode' => 'urldecode',
            'html_entities' => 'htmlentities',
            'strip_tags' => 'strip_tags',
            'encrypt' => 'encrypt',
            'decrypt' => 'decrypt',
        ];
    }

    public function render() {
        if ($this->data !== NULL)
            extract($this->data);

        $file_path = app_views_url . "{$this->name}.php";

        if (!file_exists($file_path)) {
            throw new \Exception("trying to render file $file_path that doesn't exist");
        }

        $content = $this->get_content(app_views_url . "{$this->name}.php");

        // Parse @set
        $content = preg_replace('/@set\((.*?),\s*(.*?)\)/', '<?php $this->data[\'$1\'] = $2; ?>', $content);

        // Parse @if, @endif
        $content = preg_replace('/@if \((.*?)\)/', '<?php if ($1): ?>', $content);
        $content = str_replace('@endif', '<?php endif; ?>', $content);

        // Parse @elseif, @else
        $content = preg_replace('/@elseif \((.*?)\)/', '<?php elseif ($1): ?>', $content);
        $content = str_replace('@else', '<?php else: ?>', $content);

        // Parse @foreach, @endforeach
        $content = preg_replace('/@foreach \((.*?) as (.*?) => (.*?)\)/', '<?php foreach ($1 as $2 => $3): ?>', $content);
        $content = str_replace('@endforeach', '<?php endforeach; ?>', $content);

        // Parse @for, @endfor
        $content = preg_replace('/@for \((.*?)\)/', '<?php for ($1): ?>', $content);
        $content = str_replace('@endfor', '<?php endfor; ?>', $content);

        // Parse @while, @endwhile
        $content = preg_replace('/@while \((.*?)\)/', '<?php while ($1): ?>', $content);
        $content = str_replace('@endwhile', '<?php endwhile; ?>', $content);

        // Parse @switch, @case, @default, @endswitch
        $content = preg_replace('/@switch\((.*?)\)/', '<?php switch ($1): ?>', $content);
        $content = preg_replace('/@case\((.*?)\)/', '<?php case $1: ?>', $content);
        $content = str_replace('@default', '<?php default: ?>', $content);
        $content = str_replace('@endswitch', '<?php endswitch; ?>', $content);

        // Parse @isset, @endisset
        $content = preg_replace('/@isset\((.*?)\)/', '<?php if (isset($1)): ?>', $content);
        $content = str_replace('@endisset', '<?php endif; ?>', $content);

        // Parse @empty, @endempty
        $content = preg_replace('/@empty\((.*?)\)/', '<?php if (empty($1)): ?>', $content);
        $content = str_replace('@endempty', '<?php endif; ?>', $content);

        // Parse @include
        $content = preg_replace('/@include\(\'(.*?)\'\)/', '<?php include $1; ?>', $content);

        // Parse {{-- --}}
        $content = preg_replace('/{{--(.*?)--}}/', '<?php /* $1 */ ?>', $content);

        // Parse @php, @endphp
        $content = preg_replace('/@php(.*?)@endphp/s', '<?php $1 ?>', $content);

        // Parse {{ | filters }}
        $content = preg_replace_callback('/{{(.*?)\|(.*?)}}/', function ($matches) {
            $variable = trim($matches[1]);
            $filters = array_map('trim', explode(' ', $matches[2]));

            $filteredVariable = $variable;
            foreach ($filters as $filter) {
                if (empty ($filter))
                    continue;
                if (!isset ($this->filters[$filter])) {
                    throw new \Exception("Unknown filter: $filter");
                }

                $filteredVariable = $this->filters[$filter] . '(' . $filteredVariable . ')';
            }

            return '<?= ' . $filteredVariable . '; ?>';
        }, $content);

        // Parse {{ }}, {{{ }}}
        $content = preg_replace('/{{{(.*?)}}}/', '<?= htmlspecialchars($1, ENT_QUOTES, \'UTF-8\'); ?>', $content);
        $content = preg_replace('/{{(.*?)}}/', '<?= $1; ?>', $content);

        // Parse @section, @endsection
        $content = preg_replace('/@section\(\'(.*?)\'\)(.*?)@endsection/s', '<?php $this->section(\'$1\'); ?>$2<?php $this->end_section(); ?>', $content);

        // Parse @extend
        $content = preg_replace('/@extend\(\'(.*?)\'\)/', '<?php $this->extend(\'$1\'); ?>', $content);

        // Parse @include
        $content = preg_replace('/@include\(\'(.*?)\'\)/', '<?php $this->include(\'$1\'); ?>', $content);

        // Parse @dump
        $content = preg_replace_callback('/@dump\((.*?)\)/', function ($matches) {
            $expression = $matches[1];

            return '<?php
                $result = ' . $expression . ';
                if (is_array($result)) {
                    echo "<pre>";
                    print_r($result);
                    echo "</pre>";
                } else if (is_object($result)) {
                    echo "<pre>";
                    var_export($result);
                    echo "</pre>";
                } else {
                    echo $result;
                }
            ?>';
        }, $content);

        $content = str_replace('@csrf', '<?= generate_csrf_token(); ?>', $content);

        eval ('?>' . $content);
    }

    private function get_content($file_path) {
        if (!file_exists($file_path)) {
            throw new \Exception("File $file_path does not exist");
        }

        return file_get_contents($file_path);
    }

    public function section($name) {
        $this->section_stack[] = $name;
        ob_start();
    }

    public function end_section() {
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

    public function render_section($name) {
        if (!isset ($this->sections[$name])) {
            echo '';
            return;
        }

        foreach ($this->sections[$name] as $key => $contents) {
            echo $contents;
            unset($this->sections[$name][$key]);
        }
    }

    public function extend($layout) {
        // $view = new View($layout, $this->data);
        // $view->sections = $this->sections;
        // $view->render();

        $this->name = $layout;
    }

    public function include($layout) {
        $view = new View($layout, $this->data);
        $view->render();
    }

    public function get_name() {
        return $this->name;
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function __get($name) {
        return isset ($this->$name)
            ? $this->$name
            : $this->data[$name];
    }
}
