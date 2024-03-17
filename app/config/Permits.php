<?php

$permits->add('/auth', function ($route, $method): bool {
    return isset ($_GET['login']) || isset ($_GET['register']) || isset ($_GET['logout']);
});
