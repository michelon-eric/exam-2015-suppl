<?php

$routes->get('/', 'IndexController::index');

$routes->get('/tos', 'IndexController::tos');
$routes->get('/faq', 'IndexController::faq');

$routes->get('/partials/auth/login', 'PartialsController::login');
$routes->get('/partials/auth/register', 'PartialsController::register');

$routes->get('/partials/useredit/usereditform', 'PartialsController::useredit');
$routes->get('/partials/useredit/upgradetoadmin', 'PartialsController::useredit_upgradetoadmin');
$routes->get('/partials/useredit/upgradegobackbutton', 'PartialsController::useredit_upgradegobackbutton');
$routes->get('/partials/useredit/upgradetoadminbutton', 'PartialsController::useredit_upgradetoadminbutton');

$routes->get('/partials/centres/all', 'PartialsController::centres_all');

$routes->get('/auth', 'IndexController::auth');
$routes->post('/auth/register', 'auth\AuthController::register');
$routes->post('/auth/login', 'auth\AuthController::login');
$routes->post('/auth/logout', 'auth\AuthController::logout');
$routes->get('/useredit', 'IndexController::useredit');
$routes->post('/useredit', 'UserController::useredit');

$routes->get('/dashboard', 'IndexController::dashboard');

$routes->post('/centre/add', 'CentreController::add');
$routes->post('/centre/edit', 'CentreController::edit');
$routes->get('/centres', 'CentreController::index');
$routes->get('/centres/centre', 'CentreController::centre');
$routes->get('/centres/centre/dashboard', 'CentreController::dashboard');