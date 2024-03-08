<?php

namespace App\Controllers;

use App\Models\UserModel;
use Lib\Database\Database;
use Lib\Systems\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        view('page_picker');
    }

    public function home()
    {
        $user = (new UserModel())->find(session()->get('user-id'));
        print_r($user);
    }

    public function tos()
    {
        view('tos');
    }
}
