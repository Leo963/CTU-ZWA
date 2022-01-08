<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrace - Uživatel</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
<?php
require_once '../init.php';

if (isset($_POST['uid'],$_POST['username'],$_POST['fname'],$_POST['lname'],$_POST['dob'])) {
    $users->updateUser($_POST['uid'],$_POST['username'],$_POST['fname'],$_POST['lname'],$_POST['dob']);
    if (isset($_POST['email'])) {
        $users->setEmail($_POST['username'],$_POST['email']);
    }
}

if (isset($_POST['id'])) {
    $userDetails = $users->getUserById($_POST['id']);
} else {
    header('Location: students.php');
    die();
}


const CLASSLENGTH = "+1 hour +30 minutes";

include '../header.php';
?>
<div class="content">
    <?php include '../nav.php' ?>

    <section class="main admin">
        <h2>Administrace - Uživatel</h2>
        <article class="settings admin">
            <h2>Nastavení účtu</h2>
            <div class="container" id="admin">
                <div id="properties">
                    <fieldset id="props">
                        <legend>Vlastnosti</legend>
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" id="propForm">
                            <label for="username">
                                Uživatelské jméno
                            </label>
                            <input type="text" id="username" name="username"
                                   value="<?= htmlspecialchars($userDetails['uname']) ?>">
                            <label for="fname">
                                Jméno
                            </label>
                            <input type="text" id="fname" name="fname"
                                   value="<?= htmlspecialchars($userDetails['fname']) ?>">
                            <label for="lname">
                                Příjmení
                            </label>
                            <input type="text" id="lname" name="lname"
                                   value="<?= htmlspecialchars($userDetails['lname']) ?>">
                            <label for="dob">
                                Datum narození
                            </label>
                            <input type="date" id="dob" name="dob" value="<?= $userDetails['dob'] ?>">
                            <?php if (isset($userDetails['email'])) {
                                echo '<label for="email">
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="' . $userDetails['email'] . '">';
                            }
                            ?>
                            <input type="hidden" name="uid" value="<?= $userDetails['id'] ?>">
                            <input type="submit" value="Upravit">
                        </form>
                    </fieldset>
                </div>
            </div>
        </article>
    </section>
</div>
</body>
</html>
