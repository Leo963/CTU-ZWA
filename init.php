<?php

session_start();

spl_autoload_register(function ($className)
{
    /** @noinspection PhpIncludeInspection */
    require_once 'model/' . $className . '.php';
});

if (!isset($_SESSION['user']) && !(strpos($_SERVER['PHP_SELF'],'login.php') || strpos($_SERVER['PHP_SELF'],'signup.php'))) {
    header('Location: login.php');
    die();
}

$dataLayer = new DataLayer();
$users = new UserRepository($dataLayer);