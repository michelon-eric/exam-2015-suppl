<?php /** @var \Lib\Systems\Views\View $this */
foreach (get_defined_vars() as $name => $value) {
    if ($name === 'this')
        continue;
    $this->$name = $$name ?? '';
}

$this->role = session()->get('user-role');
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

    <!-- hyperscript -->
    <script src="<?= assets_path('js/_hyperscript/_hyperscript.min.js') ?>"></script>

    <!-- register methods -->
    <script type="module" src="<?= assets_path() ?>js/auth/register.js"></script>
    <script type="module" src="<?= assets_path() ?>js/auth/login.js"></script>
    <script type="module" src="<?= assets_path() ?>js/useredit/useredit.js"></script>
    <script type="module" src="<?= assets_path() ?>js/useredit/upgradetoadmin.js"></script>
    <script type="module" src="<?= assets_path() ?>js/centres/centre/edit.js"></script>

    <?= $this->render_section('include') ?>
</head>

<body class="transition-colors duration-200 dark:bg-gray-950" hx-boost="true">
    <?php if (isset ($navbar)): ?>
        <?= $this->include('layout/partials/navbar') ?>
    <?php endif; ?>

    <div id="content" class="content p-10 dark:text-white text-black">
        <?= $this->render_section('content') ?>
    </div>
</body>

</html>