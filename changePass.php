<?php
require_once 'init.php';

$user = $users->getUser($_SESSION['user']);

if (password_verify($_POST['currentPass'],$user['pass'])) {
    if ($_POST['newPass'] == $_POST['confirmPass']) {
        if ($users->updatePassword($_SESSION['user'],$user['id'],password_hash($_POST['confirmPass'], PASSWORD_BCRYPT))) {
            header('Location: user.php?update=1');
            die();
        }
    }
}

header('Location: user.php?update=0');