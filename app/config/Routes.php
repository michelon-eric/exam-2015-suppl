<?php

$routes->get('/', 'IndexController::index');

$routes->get('/tos', 'IndexController::tos');
$routes->get('/faq', 'IndexController::faq');

$routes->get('/partials/auth/login', 'PartialsController::login');
$routes->get('/partials/auth/register', 'PartialsController::register');
$routes->get('/partials/useredit/useredit', 'PartialsController::useredit');
$routes->get('/partials/useredit/upgradetoadmin', 'PartialsController::useredit_upgradetoadmin');

$routes->get('/auth', 'IndexController::auth');
$routes->post('/auth/register', 'auth\AuthController::register');
$routes->post('/auth/login', 'auth\AuthController::login');
$routes->post('/auth/logout', 'auth\AuthController::logout');
$routes->get('/useredit', 'IndexController::useredit');
$routes->post('/useredit', 'UserController::useredit');

$routes->get('/dashboard', 'IndexController::dashboard');

$routes->post('/centre/add', 'CentreController::add');
$routes->get('/centres/dashboard', 'CentreController::dashboard');
$routes->get('/centres/centre/dashboard', 'CentreController::centre_dashboard');
