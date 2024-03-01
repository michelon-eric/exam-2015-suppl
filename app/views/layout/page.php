<?php

/** @var \Lib\Systems\Views\View $this */ ?>

<!DOCTYPE html>
<html lang="en" class="dark h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->render_section('title') ?></title>

    <script src="<?= assets_path('js\jquery\jquery.min.js') ?>" defer></script>
    <!-- <script src="<?= '' // assets_path('js\bootstrap\bootstrap.bundle.min.js') 
                        ?>" defer></script> -->

    <!-- <link rel="stylesheet" type="text/css" href="<?= '' // assets_path('css\bootstrap\bootstrap.min.css') 
                                                        ?>"> -->

    <script src="<?= assets_path('js\waves\waves.min.js') ?>" defer></script>
    <link rel="stylesheet" type="text/css" href="<?= assets_path('css\waves\waves.min.css') ?>">

    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

    <link rel="stylesheet" type="text/css" href="<?= assets_path('dist\css\app.css') ?>">

    <!-- <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->


    <!-- preline -->
    <script src="<?= base_url() ?>node_modules/preline/dist/preline.js" defer></script>

    <!-- <script src="<?= assets_path('js\navbar.js') ?>" defer></script> -->
    <script src="<?= assets_path('js\sidebar.js') ?>" defer></script>

    <script src="<?= assets_path('js/htmx/htmx.min.js') ?>"></script>

    <?= $this->render_section('include') ?>
</head>

<body class="transition-colors duration-200 dark:bg-gray-950">
    <?= $this->include('layout/navbar') ?>

    <?= $this->include('layout/sidebar') ?>

    <div class="content p-10 dark:text-white text-black">
        <?= $this->render_section('content') ?>
    </div>

    <?= $this->include('layout/footer') ?>
</body>

</html>