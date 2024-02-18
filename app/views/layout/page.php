<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->render_section('title') ?></title>

    <script src="<?= assets_path('js/jquery/jquery.min.js') ?>" defer></script>
    <script src="<?= assets_path('js/bootstrap/bootstrap.bundle.min.js') ?>" defer></script>

    <link rel="stylesheet" type="text/css" href="<?= assets_path('css/bootstrap/bootstrap.min.css') ?>">

    <?= $this->render_section('include') ?>
</head>

<body>
    <?= $this->render_section('content') ?>
</body>

</html>