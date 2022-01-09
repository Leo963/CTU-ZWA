<?php
require_once '../init.php';

if (!isset($_GET['id'])) {
    header('Location: subjects.php');
    die();
}

$urepo = new UserRepository($dataLayer);
$srepo = new SubjectRepository($dataLayer);
$crepo = new ClassRepository($dataLayer);

$lectures = $crepo->getClassesBySubjectIdAndType($_GET['id'], Helper::LECTURE);
$practicals = $crepo->getClassesBySubjectIdAndType($_GET['id'], Helper::PRACTICAL);
$labs = $crepo->getClassesBySubjectIdAndType($_GET['id'], Helper::LAB);

if (isset(
    $_POST['anotation'],
    $_POST['description'],
    $_POST['length']
)) {
    $srepo->updateDetails($_GET['id'],$_POST['anotation'],$_POST['description'],$_POST['length']);
}

$subject = $srepo->getSubjectDetailsById($_GET['id']);

/**
 * @param array $classes
 * @param ClassRepository $crepo
 * @return string
 */
function prepareClassesAdmin(array $classes, ClassRepository $crepo): string
{

    $lectureStruct = "";
    foreach ($classes as $lecture) {
        $lectureStruct .= "<div class='class'>";
        $lectureStruct .= "
                    <header>
                        <h2>" .
            mb_convert_case(strftime('%A', strtotime("Sunday +$lecture[dayOfWeek] days")), MB_CASE_TITLE) . "
                        </h2>
                        <span><time>" .
            date('H:i', strtotime($lecture['timeOfDay'])) . "
                        </time>-<time>" .
            date('H:i', strtotime(Helper::CLASSLENGTH, strtotime($lecture['timeOfDay']))) . "
                        </time></span>
                    </header>
                    ";
        $lectureStruct .= "
                    <section class='class'>
                        <h2>".htmlspecialchars($lecture['teacher'])."</h2>
                        <p>".htmlspecialchars($lecture['location'])."</p>
                        ";
        if ($crepo->isAnyoneSignedUp($lecture['id'])) {
            $lectureStruct .= "<p class='error'>Uživatelé již mají tuto paralelku zapsanou</p>";
            $lectureStruct .= "<form action='deleteClass.php' method='post'>
            <label>
                Opravdu checte smazat?
                <input type='checkbox' name='check' value='1' required>
            </label>
            <input type='submit' name='delete' value='Smazat'>
            <input type='hidden' name='class' value='$lecture[id]'>
            <input type='hidden' name='subject' value='$_GET[id]'>
            </form>";
        } else {
            $lectureStruct .= "<form action='deleteClass.php' method='post'>
            <input type='hidden' name='class' value='$lecture[id]'>
            <input type='hidden' name='subject' value='$_GET[id]'>
            <input type='submit' value='Smazat'>
            </form>";
        }


        $lectureStruct .= "</section>
        </div>";
    }
    return $lectureStruct;
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
    <link rel="stylesheet" href="../css/subjectDetail.css">
    <title>Administrace - <?= $subject['code'] ?></title>
</head>
<body>
<?php
include '../header.php';
?>
<div class="content">
    <?php include '../nav.php' ?>

    <section class="main">
        <h2>Předmět - <?= htmlspecialchars($subject['code']) ?> - <?= htmlspecialchars($subject['name']) ?></h2>
        <article class="settings">
            <h2>Detaily předmětu</h2>
            <form action="<?= $_SERVER['REQUEST_URI'] ?>" id="properties" method="post">
                <label for="length">
                    Délka (v týdnech):
                    <input type="number" value="<?= $subject['length'] ?>" name="length" id="length" min="1" max="42">
                </label>
                <label for="anotation">
                    Anotace
                </label>
                <textarea name="anotation" id="anotation" cols="20" rows="3"
                          maxlength="150"><?= htmlspecialchars($subject['anotation']) ?></textarea>
                <label for="description">
                    Popis
                </label>
                <textarea name="description" id="anotation" cols="20" rows="10"
                          maxlength="500"><?= htmlspecialchars($subject['description']) ?></textarea>
                <input type="submit" value="Aktualizovat">
            </form>
        </article>
        <article class="classes">
            <h2>Paraleky</h2>
            <a href="newClass.php?subject=<?= $_GET['id'] ?>">Přidat paralelku</a>
            <?php
            if ($lectures) {
                echo "<fieldset>" .
                    "<legend>Přednášky</legend>" .
                    prepareClassesAdmin($lectures, $crepo) .
                    "</fieldset>";
            }
            if ($practicals) {
                echo "<fieldset>" .
                    "<legend>Cvičení</legend>" .
                    prepareClassesAdmin($practicals, $crepo) .
                    "</fieldset>";
            }
            if ($labs) {
                echo "<fieldset>" .
                    "<legend>Laboratoře</legend>" .
                    prepareClassesAdmin($labs, $crepo) .
                    "</fieldset>";
            }
            ?>
        </article>
    </section>
</div>
</body>
</html>
