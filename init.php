<?php

session_start();

spl_autoload_register(function ($className)
{
    /** @noinspection PhpIncludeInspection */
    require_once 'model/' . $className . '.php';
});


$dataLayer = new DataLayer();