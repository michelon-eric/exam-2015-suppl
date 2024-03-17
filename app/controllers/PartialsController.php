<?php

namespace App\Controllers;

use App\Models\CentreModel;
use App\Models\ResourceModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use Lib\Systems\Controllers\Controller;

class PartialsController extends Controller {
    public function login() {
        view('pages/auth/partials/login');
    }
    public function register() {
        view('pages/auth/partials/register');
    }

    public function useredit() {
        view('pages/useredit/partials/usereditform', [
            'user' => (new UserModel())->find(session()->get('user-id')),
        ]);
    }

    public function useredit_upgradetoadmin() {
        view('pages/useredit/partials/upgradetoadmin');
    }

    public function useredit_upgradegobackbutton() {
        view('pages/useredit/partials/upgradegobackbutton');
    }

    public function useredit_upgradetoadminbutton() {
        view('pages/useredit/partials/upgradetoadminbutton');
    }

    public function centres_all() {
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

            $centre['CTR_ModeratorsCount'] = $role_model
                ->query("SELECT COUNT(*) as ModCount FROM `" . $role_model->get_table() . "` WHERE `ROL_IdCentre` = $centre_id AND `ROL_IdUser` = $user_id AND NOT `ROL_Role` = 'Regular'", [])
                ->get_result()
                ->fetch_assoc()['ModCount'];
            return $centre;
        }, $centres);

        view('pages/centres/partials/all', ['centres' => $centres]);
    }
}
