<?php
    require_once "init.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landing page</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/landing.css">
</head>
<?php
    $_SESSION['role'] = $users->getUser($_SESSION['user'])['role'];
?>
<body>
<?php include 'header.php' ?>
<div class="content">
    <?php include 'nav.php' ?>
    <section class="main">
        <h4>Dnes je <?= date("d.m.Y") ?></h4>
        <article id='welcome'>
        <h2>Vítejte na stránkách Studentské Organizační Platformy</h2>
        <p>Tato stránka vám umožní se zapsat do předmětů a rozšířit své obzory</p>
        </article>
    </section>
</div>


</body>
</html>