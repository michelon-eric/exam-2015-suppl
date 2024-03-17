<?php

namespace App\Controllers\Auth;

use App\Models\UserModel;
use App\Models\UserRoleModel;
use Lib\Database\Database;
use Lib\Systems\Controllers\Controller;

class AuthController extends Controller
{
    public function manager_register()
    {
        session()->set('user-role', 'Moderator');
        return view('auth/register', [
            'type' => 'manager',
        ]);
    }

    public function manager_login()
    {
        session()->set('user-role', 'Moderator');
        return view('auth/login', [
            'type' => 'manager',
        ]);
    }

    public function user_register()
    {
        session()->set('user-role', 'Regular');
        return view('auth/register', [
            'type' => 'regular',
        ]);
    }
    public function user_login()
    {
        session()->set('user-role', 'Regular');
        return view('auth/login', [
            'type' => 'regular',
        ]);
    }

    public function register()
    {
        $email = $this->request->get_post('email');
        $password = $this->request->get_post('password');
        $password_conf = $this->request->get_post('confirm-password');
        $first_name = $this->request->get_post('first-name');
        $last_name = $this->request->get_post('last-name');

        $user_model = new UserModel();

        if (!validate_email($email)) {
            $error = json_encode(['fail' => 'email']);
            log_error($error);
            return $error;
        }

        // TODO: password strength

        $existing_user = $user_model->select_where_first(['USR_Email' => $email]);
        if (is_array($existing_user)) {
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
        ]);

        if ($insert_id === false) {
            $error = 'error while creating user, try again';
            log_error($error);
            return json_encode(['fail' => $error]);
        }

        session()->set('user-id', $insert_id);
        session()->set('user-role', 'Regular');

        log_info('registered user: ' . $email . ' with id: ' . $insert_id);

        redirect('dashboard');
        // return json_encode(['success' => 'home']);
    }

    public function login()
    {
        // TODO: fix error screen
        $email = $this->request->get_post('email');
        $password = $this->request->get_post('password');
        $rember_me = $this->request->get_post('remember-me') === 'true';

        $user_model = new UserModel();
        $user = $user_model->select_where_first(['USR_Email' => $email]);

        if ($user === false || $user === null) {
            return json_encode(['fail' => 'email']);
        }

        if (!check_chash($user['USR_Password'], $password)) {
            return json_encode(['fail' => 'password']);
        }

        session()->set('user-id', $user['USR_Id']);
        if ($rember_me) {
            // TODO: remember me
            log_debug('rember to add rember me');
        }

        $role_model = new UserRoleModel();
        $user_id = $user['USR_Id'];
        $result = $role_model
            ->query("SELECT * FROM `" . $role_model->get_table() . "` WHERE `ROL_Role` IN ('Moderator', 'Administrator', 'Root') AND `ROL_IdUser` = $user_id", [])
            ->get_result()
            ->fetch_assoc();

        $role = is_array($result) ? $result['ROL_Role'] : 'Regular';
        session()->set('user-role', $role);

        log_info("logged in $role user: $email with id: " . $user['USR_Id']);

        redirect('dashboard');

        return json_encode(['success' => 'home']);
    }
}
