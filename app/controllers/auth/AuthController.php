<?php

namespace App\Controllers\Auth;

include lib_controllers_url . 'Controller.php';

use Lib\Systems\Controllers\Controller;

class AuthController extends Controller
{
    public function manager_register()
    {
        return view('auth/register', [
            'type' => 'manager',
        ]);
    }

    public function manager_login()
    {
        return view('auth/login', [
            'type' => 'manager',
        ]);
    }


    public function user_register()
    {
        return view('auth/register', [
            'type' => 'regular',
        ]);
    }
    public function user_login()
    {
        return view('auth/login', [
            'type' => 'regular',
        ]);
    }

    public function exec_manager_register()
    {
        redirect('/home');
    }
}
