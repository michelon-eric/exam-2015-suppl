<?php

$routes->get('/', 'HomeController::index');

$routes->get('/auth/signin', 'Auth\AuthController::signin');
$routes->get('/auth/signup', 'Auth\AuthController::signup');
