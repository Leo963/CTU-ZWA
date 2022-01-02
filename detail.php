<!doctype html>
<?php
require_once 'init.php';

const LECTURE = 1;
const PRACTICAL = 2;
const LAB = 3;
const CLASSLENGTH = "+1 hour +30 minutes";

$srepo = new SubjectRepository($dataLayer);
$crepo = new ClassRepository($dataLayer);

if (isset($_GET['id'])) {
    $subject = $srepo->getSubjectByid($_GET['id']);
    $subjectDetails = $srepo->getSubjectDetailsById($_GET['id']);
    $lectures = $crepo->getClassesBySubjectIdAndType($_GET['id'], LECTURE);
    $practicals = $crepo->getClassesBySubjectIdAndType($_GET['id'], PRACTICAL);
    $labs = $crepo->getClassesBySubjectIdAndType($_GET['id'], LAB);
} else {
    header('Location: subjects.php');
    die();
}

/**
 * @param array $classes
 * @return string
 */
function prepareClasses(array $classes): string
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
            date('H:i', strtotime(CLASSLENGTH, strtotime($lecture['timeOfDay']))) . "
                        </time></span>
                    </header>
                    ";
        $lectureStruct .= "
                    <section class='class'>
                        <h2>$lecture[teacher]</h2>
                        <p>$lecture[location]</p>
                        <form action='subjectsignup.php' method='POST'>
                            <input type='hidden' name='student' value='$_SESSION[user]'>
                            <input type='hidden' name='class' value='$lecture[id]'>
                            <input type='hidden' name='detail' value='$_GET[id]'>
                            <input type='submit' value='Zapsat'>
                        </form>
                    </section>";
        $lectureStruct .= "</div>";
    }
    return $lectureStruct;
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $subject['code'] ?> - Detail</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/detail.css">
</head>
<body>
<?php
include 'header.php';
?>
<div class="content">
    <?php include 'nav.php' ?>

    <section class="main">
        <header>
            <h2>Detail předmětu</h2>
            <h2><?= $subject['code'] ?> - <?= $subject['name'] ?></h2>
        </header>
        <div class="data">
            <article class="info">
                <fieldset>
                    <legend>Anotace</legend>
                    <p><?= $subjectDetails['anotation'] ?></p>
                </fieldset>
                <fieldset>
                    <p>Délka předmětu: <?= $subjectDetails['length'] ?> týdnů</p>
                    <p>Formát předmětu:
                        <?= $subjectDetails['lectures'] ?>P+
                        <?= $subjectDetails['practicals'] ?>C+
                        <?= $subjectDetails['labs'] ?>L
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Popis</legend>
                    <p><?= $subjectDetails['description'] ?></p>
                </fieldset>
            </article>
            <article class="classes">
                <?php
                if ($lectures) {
                    echo "<fieldset>".
                    "<legend>Přednášky</legend>".
                    prepareClasses($lectures).
                    "</fieldset>";
                }
                if ($practicals) {
                    echo "<fieldset>".
                    "<legend>Cvičení</legend>".
                    prepareClasses($practicals).
                    "</fieldset>";
                }
                if ($labs) {
                    echo "<fieldset>".
                    "<legend>Laboratoře</legend>".
                    prepareClasses($labs).
                    "</fieldset>";
                }
                ?>
            </article>
        </div>
    </section>
</div>
</body>
</html>
