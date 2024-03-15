<?php

namespace App\Controllers;

use App\Models\UserModel;
use Lib\Systems\Controllers\Controller;

class PartialsController extends Controller
{
    public function login()
    {
        view('pages/auth/partials/login');
    }
    public function register()
    {
        view('pages/auth/partials/register');
    }

    public function useredit()
    {
        view('pages/useredit/partials/useredit', [
            'user' => (new UserModel())->find(session()->get('user-id')),
        ]);
    }

    public function useredit_upgradetoadmin()
    {
        view('pages/useredit/partials/upgradetoadmin');
    }
}
