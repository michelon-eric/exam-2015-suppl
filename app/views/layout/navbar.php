<?php

/** @var \Lib\Systems\Views\View $this */ ?>

<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-end mb-0">
        <li class="dropdown">
            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" aria-haspopup=" false" aria-expanded="false">
                <span class="pro-user-name ms-1">
                    User <i class="bi bi-caret-down-fill"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header">
                    <h6 class="m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="<?= base_url() ?>user\view" class="dropdown-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="<?= base_url() ?>auth\logout" class="dropdown-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>

        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <!-- <i class="fe-settings noti-icon"></i> -->
            </a>
        </li>
    </ul>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <div class="box d-flex align-items-center justify-content-center">
            <span style="font-size: 2.3rem; color: #6e768e;">meow</span>
        </div>

        <li>
            <h4 class="page-title-main">Dashboard</h4>
        </li>
    </ul>

    <div class="clearfix"></div>
</div>