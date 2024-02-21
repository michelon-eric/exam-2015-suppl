<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->render_section('title') ?></title>

    <script src="<?= assets_path('js\jquery\jquery.min.js') ?>" defer></script>
    <script src="<?= assets_path('js\bootstrap\bootstrap.bundle.min.js') ?>" defer></script>

    <link rel="stylesheet" type="text/css" href="<?= assets_path('css\bootstrap\bootstrap.min.css') ?>">

    <script src="<?= assets_path('js\waves\waves.min.js') ?>" defer></script>
    <link rel="stylesheet" type="text/css" href="<?= assets_path('css\waves\waves.min.css') ?>">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?= assets_path('css\app.css') ?>">

    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


    <script src="<?= assets_path('js\navbar.js') ?>" defer></script>
    <script src="<?= assets_path('js\sidebar.js') ?>" defer></script>

    <?= $this->render_section('include') ?>
</head>

<body>
    <div id="wrapper">

        <?= $this->include('layout/navbar') ?>

        <?= $this->include('layout/sidebar') ?>

        <div class="content">
            <?= $this->render_section('content') ?>
        </div>

    </div>
</body>

</html>