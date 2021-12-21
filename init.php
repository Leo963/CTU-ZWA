<?php

session_start();

spl_autoload_register(function ($className)
{
    /** @noinspection PhpIncludeInspection */
    require_once 'model/' . $className . '.php';
});

$dataLayer = new DataLayer();
$users = new UserRepository($dataLayer);

if (!(strpos($_SERVER['PHP_SELF'],'login.php') || strpos($_SERVER['PHP_SELF'],'signup.php'))) {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        die();
    }

    if (!$users->getUser($_SESSION['user'])) {
        header('Location: logout.php');
        die();
    }
}
