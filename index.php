<?php

// minimum version check
$min_php_version = '8.0';
if (version_compare(PHP_VERSION, $min_php_version, '<')) {
    $message = sprintf('The PHP version must be %s or higher to run this project, your current version is %s', $min_php_version, PHP_VERSION);
    exit ($message);
}

// path to front controller (index.php) 
define('base_url', __DIR__ . DIRECTORY_SEPARATOR);

// ensure current directory points to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== base_url) {
    chdir(base_url);
}

// Load paths config file
include base_url . 'lib/config/Paths.php';
include base_url . 'app/config/Paths.php';

define('assets_url', app_url . 'assets' . DIRECTORY_SEPARATOR);


// common functions used throughout the entire project/library
include lib_url . 'common.php';

// get app and handle request
include lib_url . 'App.php';

$app = new Lib\App();
$app->initialize();

$app->run();


exit (0);
