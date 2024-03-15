<?php

/** @var \Lib\Systems\Views\View $this */
?>

<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title ?? 'meow-default-title' ?></title>

    <!-- jquery -->
    <script src="<?= assets_path('js\jquery\jquery.min.js') ?>" defer></script>

    <!-- waves -->
    <script src="<?= assets_path('js\waves\waves.min.js') ?>" defer></script>
    <link rel="stylesheet" type="text/css" href="<?= assets_path('css\waves\waves.min.css') ?>">

    <!-- tailwind -->
    <link rel="stylesheet" type="text/css" href="<?= assets_path('dist\css\app.css') ?>">

    <!-- preline -->
    <script src="<?= base_url() ?>node_modules/preline/dist/preline.js" defer></script>

    <!-- htmx -->
    <script src="<?= assets_path('js/htmx/htmx.min.js') ?>"></script>

    <!-- register/login methods -->
    <script type="module" src="<?= assets_path() ?>js/auth/register.js"></script>
    <script type="module" src="<?= assets_path() ?>js/auth/login.js"></script>

    <?= $this->render_section('include') ?>
</head>

<body class="transition-colors duration-200 dark:bg-gray-950">
    <div id="content" class="content p-10 dark:text-white text-black">
        <?= $this->render_section('content') ?>
    </div>

    <?= $this->include('layout/footer') ?>
</body>

</html>