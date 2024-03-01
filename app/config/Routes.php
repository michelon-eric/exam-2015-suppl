<?php

$routes->get('/', 'HomeController::index');

$routes->get('/auth/manager/register', 'auth\AuthController::manager_register');
$routes->get('/auth/manager/login', 'auth\AuthController::manager_login');
$routes->get('/auth/user/register', 'auth\AuthController::user_register');
$routes->get('/auth/user/login', 'auth\AuthController::user_login');

$routes->post('/auth/manager/register', 'auth\AuthController::exec_manager_register');
$routes->post('/auth/user/register', 'auth\AuthController::exec_user_register');

$routes->get('/home', 'HomeController::home');
