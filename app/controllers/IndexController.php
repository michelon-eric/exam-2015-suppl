<?php

namespace App\Controllers;

use App\Models\CentreModel;
use App\Models\ResourceModel;
use App\Models\UserModel;
use Lib\Database\Database;
use Lib\Systems\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // TODO: rember me
        if (!session()->is_set('user-id')) {
            session()->set('user-role', 'Unset');
        }
        redirect('/dashboard');
    }

    // TODO: delete old dashboard
    public function old_dashboard()
    {
        $users_model = new UserModel();
        $user = $users_model->find(session()->get('user-id'));
        // TODO: redirect if not logged while accessing dashboard
        // if ($user === null)
        // redirect('/auth/logout');

        $resources_model = new ResourceModel();
        $centres = array_map(function ($centre) use ($resources_model, $users_model) {
            $centre_id = $centre['CTR_Id'];

            // i don't liek joins
            $centre['CTR_TotalResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id]);
            $centre['CTR_BookedResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id, 'RES_Status' => 'Booked']);
            $centre['CTR_BrokenResourcesCount'] = $resources_model->select_count_where(['RES_IdCentre' => $centre_id, 'RES_Status' => 'Broken']);
            $centre['CTR_CustomersCount'] = 0;

            $centre['CTR_ModeratorsCount'] = $users_model->query("SELECT COUNT(*) as ModCount FROM `users` WHERE `USR_IdCentre` = $centre_id AND NOT `USR_Role` = 'Regular'", [])->get_result()->fetch_assoc()['ModCount'];
            return $centre;
        }, (new CentreModel())->all());

        log_debug(print_r($centres, true));

        $view_str = '';
        switch ($user['USR_Role']) {
            case 'Root':
                $view_str = 'dashboard/';
            case 'Administrator':
                $view_str = 'dashboard/administrator';
                break;
            case 'Moderator':
                $view_str = 'dashboard/moderator';
                break;
            case 'Regular':
                $view_str = 'dashboard/regular';
                break;
            default:
                // invalid role so go back to index and reset session
                session()->destroy();
                redirect(''); // exit
                break;
        }

        view($view_str, ['centres' => $centres]);
    }

    public function dashboard()
    {
        view('pages/dashboard', ['role' => session()->get('user-role')]);
    }

    public function tos()
    {
        view('pages/tos', ['role' => session()->get('user-role')]);
    }

    public function faq()
    {
        view('pages/faq', ['role' => session()->get('user-role')]);
    }

    public function auth()
    {
        // due to permits either login|register|logout will be set when here
        if ($this->request->get_get('login') !== null) {
            view('pages/auth/login', ['role' => session()->get('user-role')]);
            return;
        } else if ($this->request->get_get('register') !== null) {
            view('pages/auth/register', ['role' => session()->get('user-role')]);
            return;
        }

        session()->destroy();
        redirect('');
    }

    public function useredit()
    {
        view('pages/useredit/useredit', [
            'role' => session()->get('user-role'),
            'user' => (new UserModel())->find(session()->get('user-id')),
        ]);
    }
}
