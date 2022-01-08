<?php
require_once '../init.php';

if (!isset($_GET['subject'])) {
    header('Location: subjects.php');
    die();
}

$crepo = new ClassRepository($dataLayer);

if (isset(
        $_POST['type'],
        $_POST['teacher'],
        $_POST['timeOfDay'],
        $_POST['dayOfWeek'],
        $_POST['location'],
        $_POST['token']
    ) && isTokenValid($_POST['token'])) {
    $crepo->addNewClass($_POST['type'],
        $_POST['teacher'],
        str_replace(":","",$_POST['timeOfDay'])."00",
        $_POST['dayOfWeek'],
        $_POST['location'],
        $_GET['subject']
    );
    header('Location: subjectDetail.php?id='.$_GET['subject']);
}

$urepo = new UserRepository($dataLayer);
$srepo = new SubjectRepository($dataLayer);


$subject = $srepo->getSubjectByid($_GET['subject']);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/newClass.css">
    <title>Administrace - <?= $subject['code'] ?></title>
</head>
<body>
<?php
include '../header.php';
?>
<div class="content">
    <?php include '../nav.php' ?>

    <section class="main">
        <h2>Nová paralelka - <?= $subject['code'] ?> - <?= $subject['name'] ?></h2>
        <article class="settings">
            <h2>Vlastnosti</h2>
            <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                <label for="type">Typ paralelky</label>
                <select name="type" id="type" required>
                    <?php
                    $types = $crepo->getAllTypes();
                    foreach ($types as $type) {
                        echo "<option value='$type[id]'>$type[name]</option>";
                    }
                    ?>
                </select>
                <label for="teacher">Vyučující</label>
                <select name="teacher" id="teacher" required>
                    <?php
                    $teachers = $urepo->getAllTeachers();
                    foreach ($teachers as $teacher) {
                        echo "<option value='$teacher[id]'>$teacher[fname] $teacher[lname]</option>";
                    }
                    ?>
                </select>
                <label for="timeOfDay">Čas počátku paralelky
                    <span>(Trvání je vždy 1 hodina 30 minut)</span>
                    <span>(Možné hodnoty mezi 07:30 a 18:00)</span>
                </label>
                <input type="time" name="timeOfDay" id="timeOfDay"
                       required min="07:30" max="18:00" value="07:30">
                <label for="dayOfWeek">Den v týdnu</label>
                <select name="dayOfWeek" id="dayOfWeek">
                    <option value="1">Ponděli</option>
                    <option value="2">Úterý</option>
                    <option value="3">Středa</option>
                    <option value="4">Čtvrtek</option>
                    <option value="5">Pátek</option>
                </select>
                <label for="location">Lokace (ve formátu budova:blok-místnost)</label>
                <input type="text" id="location" name="location" pattern=".{2,}:.{1,3}-\d{2,3}" required>
                <input type="hidden" name="token" value="<?= generateToken() ?>">
                <input type="submit" value="Vytvořit">
            </form>
        </article>
    </section>
</div>
</body>
</html>
