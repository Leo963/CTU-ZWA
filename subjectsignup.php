<?php
require_once 'init.php';

$crepo = new ClassRepository($dataLayer);

$crepo->signUpUserToClass($_POST['student'],$_POST['class']);

header("Location: detail.php?id=$_POST[detail]");
die();
