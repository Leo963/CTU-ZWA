<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uživatel</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
<?php
require_once 'init.php';

$user = $users->getUser($_SESSION['user']);

include 'header.php';
?>
<div class="content">
    <?php include 'nav.php' ?>

    <section class="main">
        <h2>Nastavení účtu</h2>
        <div class="container">
            <div id="properties">
                <fieldset>
                    <legend>Vlastnosti</legend>
                    <label for="username">
                        Uživatelské jméno
                    </label>
                    <input type="text" id="username" name="username" readonly value="<?= htmlspecialchars($_SESSION['user']) ?>">
                    <label for="name">
                        Jméno
                    </label>
                    <input type="text" id="name" name="name" readonly value="<?= htmlspecialchars($user['fname']) ?>">
                    <label for="fname">
                        Příjmení
                    </label>
                    <input type="text" id="fname" name="fname" readonly value="<?= htmlspecialchars($user['lname']) ?>">
                    <label for="dob">
                        Datum narození
                    </label>
                    <input type="date" id="dob" name="dob" readonly value="<?= $user['dob'] ?>">
                    <p>Pro změnu těchto údajů kontaktujte svého vyučujícího</p>
                </fieldset>
            </div>
            <div id="settings">
                <form action="changePass.php">
                    <fieldset>
                        <legend>Nastavení</legend>
                        <label for="currentPass">
                            Původní heslo
                        </label>
                        <input type="password" id="currentPass" name="currentPass" required>
                        <label for="newPass">
                            Nové heslo
                        </label>
                        <input type="password" id="newPass" name="newPass" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[!@#$%^&*()=+\-_\[\]\{\};:'\x22\\|,<.>/?€]).{8,}$" required>
                        <label for="confirmPass">
                            Potvrzení hesla
                        </label>
                        <input type="password" id="confirmPass" name="confirmPass" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*[!@#$%^&*()=+\-_\[\]\{\};:'\x22\\|,<.>/?€]).{8,}$" required>
                        <input type="submit" value="Změnit heslo">
                    </fieldset>
                </form>
            </div>
            <?php
                if (isset($_GET['update'])) {
                    if ($_GET['update'] == 1) {
                        echo '<div class="success">Heslo bylo úspěšně změněno</div>';
                    } else {
                        echo '<div class="error">Heslo se nepodařilo změnit</div>';
                    }
                }
            ?>
        </div>
    </section>
</div>
</body>
</html>
