<?php

/**
 * Administrator levels go from 1 and up
 * Level 2 is a teacher who has the access to students and subjects
 */
const MAX_ADMIN_LEVEL = 2;

date_default_timezone_set("Europe/Prague");
setlocale(LC_ALL, 'czech.utf8');

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

if (strpos($_SERVER['PHP_SELF'],'admin/') && (!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] > MAX_ADMIN_LEVEL))) {
    header('Location: ../landing.php');
}
