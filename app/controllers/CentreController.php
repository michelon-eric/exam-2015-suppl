<?php

namespace App\Controllers;

use App\Models\CentreModel;
use App\Models\ResourceModel;
use App\Models\UserRoleModel;
use Lib\Systems\Controllers\Controller;

class CentreController extends Controller
{
    public function add()
    {
        $name = $this->request->get_post('centre-name');
        $address = $this->request->get_post('centre-address');
        $city = $this->request->get_post('centre-city');
        $zip = $this->request->get_post('centre-zip');
        $phone = $this->request->get_post('centre-phone');

        if ($name === '') {
            return json_encode(['fail' => 'name']);
        }

        if ($city === '') {
            return json_encode(['fail' => 'city']);
        }

        if ($address === '') {
            return json_encode(['fail' => 'address']);
        }

        // phone is not required
        if ($phone !== '' && !validate_phone($phone)) {
            return json_encode(['fail' => 'phone']);
        }

        if (!validate_zip($zip)) {
            return json_encode(['fail' => 'zip']);
        }

        $centre_model = new CentreModel();
        $insert_id = $centre_model->insert([
            'CTR_Name' => $name,
            'CTR_Address' => $address,
            'CTR_City' => $city,
            'CTR_PostalCode' => $zip,
            'CTR_Phone' => $phone,
        ]);

        $userrole_model = new UserRoleModel();
        $admin_id = $userrole_model->insert([
            'ROL_IdUser' => session()->get('user-id'),
            'ROL_IdCentre' => $insert_id,
            'ROL_Role' => 'Administrator',
        ]);

        session()->set('user-id-admin', $admin_id);
        session()->set('user-role', 'Administrator');

        log_info('created user-role for user ' . session()->get('user-id') . " as 'Administrator'");

        redirect('centre/dashboard', ['centre-id' => $insert_id]);

        // return json_encode(['success' => 'yay']);
    }

    public function dashboard()
    {
        $centre_model = new CentreModel();
        $role_model = new UserRoleModel();
        $resources_model = new ResourceModel();
        $user_id = session()->get('user-id');
        $centres = $centre_model
            ->query("SELECT * FROM `" . $centre_model->get_table() . "` JOIN `" . $role_model->get_table() . "` ON `ROL_IdUser` = $user_id", [])
            ->get_result()
            ->fetch_all(MYSQLI_ASSOC);

        $centres = array_map(function ($centre) use ($resources_model, $role_model, $user_id) {
            $centre_id = $centre['CTR_Id'];

            // i don't liek joins
            $centre['CTR_TotalResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id]);
            $centre['CTR_BookedResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id, 'RES_Status' => 'Booked']);
            $centre['CTR_BrokenResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id, 'RES_Status' => 'Broken']);
            $centre['CTR_CustomersCount'] = 0;

            $centre['CTR_ModeratorsCount'] = $role_model->query("SELECT COUNT(*) as ModCount FROM `" . $role_model->get_table() . "` WHERE `ROL_IdCentre` = $centre_id AND `ROL_IdUser` = $user_id AND NOT `ROL_Role` = 'Regular'", [])->get_result()->fetch_assoc()['ModCount'];
            return $centre;
        }, $centres);

        view('pages/centre/dashboard', [
            'centres' => $centres,
        ]);
    }

    public function centre_dashboard()
    {
        $centre_id = decrypt($this->request->get_get('centre'));
        echo $centre_id;
    }
}
