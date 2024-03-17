<?php

namespace App\Controllers;

use App\Models\CentreModel;
use App\Models\ResourceModel;
use App\Models\UserRoleModel;
use Lib\Systems\Controllers\Controller;

class CentreController extends Controller {
    public function add() {
        $name = $this->request->get_post('centre-name');
        $address = $this->request->get_post('centre-address');
        $city = $this->request->get_post('centre-city');
        $zip = $this->request->get_post('centre-zip');
        $phone = $this->request->get_post('centre-phone');
        $email = $this->request->get_post('centre-email');

        $centre_data = [];

        if ($name === '') {
            return json_encode(['fail' => 'name']);
        }

        $centre_data['CTR_Name'] = $name;

        if ($city === '') {
            return json_encode(['fail' => 'city']);
        }
        $centre_data['CTR_City'] = $city;

        if ($address === '') {
            return json_encode(['fail' => 'address']);
        }
        $centre_data['CTR_Address'] = $address;

        // phone is not required
        if ($phone !== '' && !validate_phone($phone)) {
            return json_encode(['fail' => 'phone']);
        }

        if ($phone !== '') {
            if (!validate_phone($phone)) {
                return json_encode(['fail' => 'phone']);
            }

            $centre_data['CTR_Phone'] = $phone;
        }

        if ($email !== '') {
            $centre_data['CTR_Email'] = $email;
            if (!validate_email($email)) {
                return json_encode(['fail' => 'email']);
            }

            $centre_data['CTR_Email'] = $email;
        }

        if (!validate_zip($zip)) {
            return json_encode(['fail' => 'zip']);
        }
        $centre_data['CTR_PostalCode'] = $zip;


        $centre_model = new CentreModel();

        $insert_id = $centre_model->insert($centre_data);

        $userrole_model = new UserRoleModel();
        $admin_id = $userrole_model->insert([
            'ROL_IdUser' => session()->get('user-id'),
            'ROL_IdCentre' => $insert_id,
            'ROL_Role' => 'Administrator',
        ]);

        session()->set('user-id-admin', $admin_id);
        session()->set('user-role', 'Administrator');

        log_info('created user-role for user ' . session()->get('user-id') . " as 'Administrator'");

        session()->set('current-centre-id', $insert_id);
        redirect('centres');
    }

    public function index() {
        view('pages/centres/index');
    }

    public function centre_dashboard() {
        $centre_id = decrypt($this->request->get_get('centre'));
        echo $centre_id;
    }
}
