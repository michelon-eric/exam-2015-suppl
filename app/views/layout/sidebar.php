<?php

/** @var \Lib\Systems\Views\View $this */ ?>

<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <div class="user-box text-center">

            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php

                    // use App\Models\UserModel;

                    // $model = new UserModel();
                    // $user = $model->find(session()->get('user-id'));
                    // if ($user == false) :
                    // // redirect('404');
                    // endif;

                    // $user = [
                    //     'USR_LAST_NAME' => 'Kaname',
                    //     'USR_FIRST_NAME' => 'Madoka',
                    // ];

                    // echo $user['USR_LAST_NAME'] . ' ' . $user['USR_FIRST_NAME'];
                    ?></a>
                <div class="dropdown-menu user-pro-dropdown">

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted left-user-info">Admin Head</p>
        </div>

        <div id="sidebar-menu">
            <ul id="left-side-menu">
                <li class="menu-title">Navigation</li>

                <li>
                    <a href="/dashboard">
                        <i class="material-icons">dashboard_outlined</i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li class="menu-title mt-2">Companies</li>

                <li>
                    <a href="<?= base_url() ?>company/add">
                        <i class="material-icons">dashboard_customize</i>
                        <span> Add Company </span>
                    </a>
                </li>

                <li>
                    <?php
                    $company_id = 0;
                    $company_data = ['CMP_COMPANY_NAME' => 'meow'];
                    ?>
                    <a class="uncollapse" id="a-<?= $company_data['CMP_COMPANY_NAME'] ?>" data-toggle="collapse"
                        data-target="#d-<?= $company_data['CMP_COMPANY_NAME'] ?>"
                        aria-controls="<?= $company_data['CMP_COMPANY_NAME'] ?>"
                        href="#d-<?= $company_data['CMP_COMPANY_NAME'] ?>">
                        <i class="material-icons">dashboard_outlined</i>
                        <span> <?= $company_data['CMP_COMPANY_NAME'] ?> </span>
                        <i id="collapse-icon" class="material-icons menu-arrow float-right">keyboard_arrow_right</i>
                    </a>
                    <div class="collapse" id="d-<?= $company_data['CMP_COMPANY_NAME'] ?>">
                        <ul class="nav-second-level">
                            <li><a href="<?= base_url() ?>company/view/<?= $company_id ?>">Dashboard</a></li>
                            <li><a href="<?= base_url() ?>company/view/<?= $company_id ?>/data">Data</a></li>
                            <li><a href="<?= base_url() ?>company/view/<?= $company_id ?>/timetable">Timetable</a></li>
                            <li><a href="<?= base_url() ?>company/view/<?= $company_id ?>/services">Services</a></li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->