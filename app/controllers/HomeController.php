<?php

namespace App\Controllers;

include lib_controllers_url . 'Controller.php';
include app_models_url . 'UserModel.php';

use Lib\Systems\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        view('home');
    }
}
