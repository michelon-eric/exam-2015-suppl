<?php

namespace App\Controllers;

use App\Models\UserModel;
use Lib\Systems\Controllers\Controller;

class UserController extends Controller
{
    public function useredit()
    {
        $email = $this->request->get_post('email');
        $first_name = $this->request->get_post('first-name');
        $last_name = $this->request->get_post('last-name');
        $password = $this->request->get_post('current-password');
        $new_password = $this->request->get_post('new-password');
        $new_password_conf = $this->request->get_post('new-password-conf');

        $user_model = new UserModel();
        $user = $user_model->find(session()->get('user-id'));

        log_debug($user['USR_Password'] . ' - ' . chash($password));

        if ($password === '' || !check_chash($user['USR_Password'], $password)) {
            return json_encode(['fail' => 'password1']);
        }

        if (!validate_email($email)) {
            return json_encode(['fail' => 'email']);
        }

        $found_user = $user_model->select_where_first(['USR_Email' => $email]);
        if ($found_user !== null && $found_user['USR_Id'] != $user['USR_Id']) {
            return json_encode(['fail' => 'email-2']);
        }

        if ($new_password !== '') {
            if (!validate_password($new_password)) {
                return json_encode(['fail' => 'new-password']);
            }

            if ($new_password !== $new_password_conf) {
                return json_encode(['fail' => 'new-password-conf']);
            }

            $new_password = chash($new_password);
        } else {
            $new_password = $user['USR_Password'];
        }

        if ($first_name === '')
            $first_name = $user['USR_FirstName'];
        if ($last_name === '')
            $last_name = $user['USR_LastName'];

        if (
            $user_model->update($user['USR_Id'], [
                'USR_FirstName' => $first_name,
                'USR_LastName' => $last_name,
                'USR_Email' => $email,
                'USR_Password' => $new_password,
            ])
        ) {
            return json_encode(['success' => 'yay']);
        }

        return json_encode(['fuck' => 'meow']);
    }
}
