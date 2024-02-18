<?php

namespace Lib\Systems\Controllers;

include lib_url . 'common.php';
include lib_url . 'Request.php';

class Controller
{
    /** @var \Lib\Request */
    protected $request;

    public function __construct($get_params, $post_params)
    {
        $this->request = new \Lib\Request($get_params, $post_params);
    }
}
