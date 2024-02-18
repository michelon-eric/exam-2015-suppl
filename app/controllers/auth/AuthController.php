<?php

namespace App\Controllers\Auth;

include lib_controllers_url . 'Controller.php';

use Lib\Systems\Controllers\Controller;

class AuthController extends Controller
{
    public function index()
    {
    }

    public function signin()
    {
        echo 'signin';
    }

    public function signup()
    {
        return 'signup';
    }
}
