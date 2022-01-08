<?php
spl_autoload_register(function ($className)
{
    /** @noinspection PhpIncludeInspection */
    require_once 'model/' . $className . '.php';
});
$dataLayer = new DataLayer();
$users = new UserRepository($dataLayer);
if (isset($_GET['uname'])) {
    if($users->getUser($_GET['uname'])) echo '400';
    else echo '200';
}