<?php
require_once '../init.php';

$crepo = new ClassRepository($dataLayer);
$urepo = new UserRepository($dataLayer);
$srepo = new SubjectRepository($dataLayer);

if (isset(
        $_POST['code'],
        $_POST['name'],
        $_POST['length'],
        $_POST['token']
    ) && isTokenValid($_POST['token'])) {
    $subjectID = $srepo->newSubject(
        $_POST['code'],
        $_POST['name']
    );

    if (isset(
        $_POST['anotation'],
        $_POST['description']
    )) {
        $srepo->updateDetails($subjectID, $_POST['anotation'],
            $_POST['description'], $_POST['length']);
    }

    header('Location: subjects.php');
    die();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/newSubject.css">
    <title>Administrace - Nový předmět</title>
</head>
<body>
<?php
include '../header.php';
?>
<div class="content">
    <?php include '../nav.php' ?>

    <section class="main">
        <h2>Nový předmět</h2>
        <article class="properties">
            <h2>Vlastnosti</h2>
            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="main">
                    <label for="code">Kód *</label>
                    <input type="text" id="code" name="code" required pattern="[A-Z]{1}\d{2}-.{2,4}" placeholder="A00-AAA">
                    <label for="name">Název *</label>
                    <input type="text" id="name" name="name" required pattern=".{3,25}">
                    <label for="length">Délka v týdnech *</label>
                    <input type="number" id="length" name="length" value="14" min="1" max="42" required>
                </div>
                <div class="details">
                    <textarea name="anotation" id="anotation" cols="20" rows="3"
                              maxlength="150"></textarea>
                    <label for="anotation">
                        Anotace
                    </label>
                    <textarea name="description" id="anotation" cols="20" rows="10"
                              maxlength="500"></textarea>
                    <label for="description">
                        Popis
                    </label>
                </div>
                <input type="hidden" name="token" value="<?= generateToken() ?>">
                <input type="submit" value="Vytvořit">
            </form>
        </article>
    </section>
</div>
</body>
</html>
