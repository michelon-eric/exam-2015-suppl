<?php

namespace App\Controllers;

include lib_controllers_url . 'Controller.php';
include app_models_url . 'UserModel.php';

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
        return 'meow';
    }
}
