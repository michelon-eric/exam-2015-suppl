<?php

$routes->get('/', 'HomeController::index');

$routes->get('/tos', 'HomeController::tos');

$routes->get('/auth/manager/register', 'auth\AuthController::manager_register');
$routes->get('/auth/manager/login', 'auth\AuthController::manager_login');
$routes->get('/auth/user/register', 'auth\AuthController::user_register');
$routes->get('/auth/user/login', 'auth\AuthController::user_login');

$routes->post('/auth/register', 'auth\AuthController::register');
$routes->post('/auth/login', 'auth\AuthController::login');

$routes->get('/home', 'HomeController::home');
