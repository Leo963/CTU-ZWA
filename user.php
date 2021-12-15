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
include 'header.php';
?>
<div class="content">
    <?php include 'nav.html' ?>

    <section class="main">
        <h2>Nastavení účtu</h2>
        <div class="container">
            <article id="properties">
                <fieldset>
                    <legend>Vlastnosti</legend>
                    <label for="username">
                        Uživatelské jméno
                    </label>
                    <input type="text" id="username" name="username" readonly>
                    <label for="name">
                        Jméno
                    </label>
                    <input type="text" id="name" name="name" readonly value="Test">
                    <label for="fname">
                        Příjmení
                    </label>
                    <input type="text" id="fname" name="fname" readonly>
                    <label for="dob">
                        Datum narození
                    </label>
                    <input type="date" id="dob" name="dob" readonly>
                    <p>Pro změnu těchto údajů kontaktujte svého vyučujícího</p>
                </fieldset>
            </article>
            <article id="settings">
                <form action="changePass.php">
                    <fieldset>
                        <legend>Nastavení</legend>
                        <label for="currentPass">
                            Původní heslo
                        </label>
                        <input type="password" id="currentPass" name="currentPass">
                        <label for="newPass">
                            Nové heslo
                        </label>
                        <input type="password" id="newPass" name="newPass">
                        <label for="confirmPass">
                            Potvrzení hesla
                        </label>
                        <input type="password" id="confirmPass" name="confirmPass">
                        <input type="submit" value="Změnit heslo">
                    </fieldset>
                </form>
            </article>
        </div>
    </section>
</div>
</body>
</html>
