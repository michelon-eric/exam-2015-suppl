<?php

namespace App\Controllers;

use Lib\Systems\Controllers\Controller;

class ErrorController extends Controller {
    public function error() {
        $error = $this->request->get_get('error');
        view('errors/error', ['error' => $error]);
    }

    public function not_found() {
        view('errors/404');
    }

    public function forbidden() {
        view('errors/403');
    }
}
