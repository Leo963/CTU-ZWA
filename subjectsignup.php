<?php
require_once 'init.php';

$crepo = new ClassRepository($dataLayer);
try {
    if($crepo->signUpUserToClass($_POST['student'],$_POST['class'])) {
        $success = 1;
    } else {
        $success = 0;
    }
} catch (PDOException $e) {

}


header("Location: detail.php?id=$_POST[detail]");
die();
