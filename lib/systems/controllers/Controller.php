<?php

namespace Lib\Systems\Controllers;

include lib_directory . 'common.php';
include lib_directory . 'Request.php';

class Controller
{
    /** @var \Lib\Request */
    protected $request;

    public function __construct($get_params, $post_params)
    {
        $this->request = new \Lib\Request($get_params, $post_params);
    }
}
