<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : '' ?></title>
</head>

<body>
    <?php include app_views_directory . "$view.php"; ?>
</body>

</html>