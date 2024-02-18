<?php

namespace App\Controllers;

include lib_controllers_directory . 'Controller.php';
include app_models_directory . 'UserModel.php';

use Lib\Systems\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // session()->set('test', 'meow');
        view('home');
    }

    public function test()
    {
        view('test');
    }
}
