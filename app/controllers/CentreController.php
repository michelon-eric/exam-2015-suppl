<?php

namespace App\Controllers;

use App\Models\CentreModel;
use App\Models\ResourceModel;
use App\Models\UserModel;
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

    public function edit() {
        $centre_id = session()->get('current-centre-id');
        $name = $this->request->get_post('centre-name');
        $address = $this->request->get_post('centre-address');
        $city = $this->request->get_post('centre-city');
        $zip = $this->request->get_post('centre-zip');
        $phone = $this->request->get_post('centre-phone');
        $email = $this->request->get_post('centre-email');

        if ($name === '') {
            return json_encode(['fail' => 'name']);
        }

        if ($city === '') {
            return json_encode(['fail' => 'city']);
        }

        if ($address === '') {
            return json_encode(['fail' => 'address']);
        }

        if ($phone !== '') {
            if (!validate_phone($phone)) {
                return json_encode(['fail' => 'phone']);
            }
        } else
            $phone = null;

        if ($email !== '') {
            if (!validate_email($email)) {
                return json_encode(['fail' => 'email']);
            }
        } else
            $email = null;

        if (!validate_zip($zip)) {
            return json_encode(['fail' => 'zip']);
        }

        $model = new CentreModel();
        $success = $model->update($centre_id, [
            'CTR_Name' => $name,
            'CTR_Address' => $address,
            'CTR_City' => $city,
            'CTR_PostalCode' => $zip,
            'CTR_Phone' => $phone,
            'CTR_Email' => $email,
        ]);

        if ($success) {
            return json_encode(['success' => 'centre data updated successfully']);
        }

        return json_encode(['fail' => 'failed to update centre data']);
    }

    public function index() {
        view('pages/centres/index');
    }

    public function centre() {
        $centre_id = $this->request->get_get('centre');
        if (!$centre_id === null)
            redirect('/centres');

        $centre_id = decrypt($centre_id);
        session()->set('current-centre-id', $centre_id);

        redirect('centres/centre/dashboard');
    }

    public function dashboard() {
        $centre_id = session()->get('current-centre-id');
        $centre = dbarray_to_object((new CentreModel())->find($centre_id));

        $resources_model = new ResourceModel();
        $role_model = new UserRoleModel();
        $user_id = session()->get('user-id');
        $statistics = [];
        $statistics['TotalResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id]);

        $statistics['BookedResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id, 'RES_Status' => 'Booked']);
        $statistics['BrokenResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id, 'RES_Status' => 'Broken']);
        $statistics['CustomersCount'] = 0;
        $statistics['ModeratorsCount'] = $role_model
            ->query("SELECT COUNT(*) as ModCount FROM `" . $role_model->get_table() . "` WHERE `ROL_IdCentre` = $centre_id AND `ROL_IdUser` = $user_id AND NOT `ROL_Role` = 'Regular'", [])
            ->get_result()
            ->fetch_assoc()['ModCount'];

        $user = dbarray_to_object((new UserModel())->find($user_id));

        view('pages/centres/centre/dashboard', [
            'centre' => $centre,
            'statistics' => dbarray_to_object($statistics),
            'user' => $user,
        ]);
    }
}
