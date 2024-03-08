<?php

namespace App\Controllers\Auth;

use App\Models\UserModel;
use Lib\Database\Database;
use Lib\Systems\Controllers\Controller;

class AuthController extends Controller
{
    public function manager_register()
    {
        session()->set('user-type', 'Moderator');
        return view('auth/register', [
            'type' => 'manager',
        ]);
    }

    public function manager_login()
    {
        session()->set('user-type', 'Moderator');
        return view('auth/login', [
            'type' => 'manager',
        ]);
    }

    public function user_register()
    {
        session()->set('user-type', 'Regular');
        return view('auth/register', [
            'type' => 'regular',
        ]);
    }
    public function user_login()
    {
        session()->set('user-type', 'Regular');
        return view('auth/login', [
            'type' => 'regular',
        ]);
    }

    public function register()
    {
        $email = $this->request->get_post('email');
        $password = $this->request->get_post('password');
        $password_conf = $this->request->get_post('password-conf');
        $first_name = $this->request->get_post('first-name');
        $last_name = $this->request->get_post('last-name');

        $user_model = new UserModel();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = json_encode(['fail' => 'email']);
            log_error($error);
            return $error;
        }

        $existing_user = $user_model->select_where_first(['USR_Email' => $email]);
        if ($existing_user !== false) {
            $error = json_encode(['fail' => 'email-2']);
            log_Error($error);
            return $error;
        }

        if (strlen($password) < 8) {
            $error = json_encode(['fail' => 'password-length']);
            log_error($error);
            return $error;
        }

        if ($password !== $password_conf) {
            $error = json_encode(['fail' => 'password-match']);
            log_error($error);
            return $error;
        }

        $insert_id = $user_model->insert([
            'USR_Email' => $email,
            'USR_Password' => chash($password),
            'USR_FirstName' => $first_name,
            'USR_LastName' => $last_name,
            'USR_Role' => session()->get('user-type'),
        ]);

        if ($insert_id === false) {
            return json_encode(['fail' => 'error while creating user, try again']);
        }

        session()->set('user-id', $insert_id);

        log_info('registered manager: ' . $email . ' with id: ' . $insert_id);

        return json_encode(['success' => 'home']);
    }

    public function login()
    {
        $email = $this->request->get_post('email');
        $password = $this->request->get_post('password');
        $rember_me = $this->request->get_post('remember-me') === 'true';

        $user_model = new UserModel();
        $user = $user_model->select_where_first(['USR_Email' => $email, 'USR_Role' => session()->get('user-type')]);

        if ($user === false || $user === null) {
            return json_encode(['fail' => 'email']);
        }

        if (!heck_chash($user['USR_Password'], $password)) {
            return json_encode(['fail' => 'password']);
        }

        session()->set('user-id', $user['USR_Id']);
        if ($rember_me) {
            log_debug('rember to add rember me');
        }

        log_info('logged in user: ' . $email . ' with id: ' . $user['USR_Id']);

        return json_encode(['success' => 'home']);
    }
}
