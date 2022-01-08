<?php
require_once 'init.php';


$srepo = new SubjectRepository($dataLayer);
$crepo = new ClassRepository($dataLayer);



if (isset($_GET['id'])) {
    $subject = $srepo->getSubjectByid($_GET['id']);
    $subjectDetails = $srepo->getSubjectDetailsById($_GET['id']);
    $lectures = $crepo->getClassesBySubjectIdAndType($_GET['id'], Helper::LECTURE);
    $practicals = $crepo->getClassesBySubjectIdAndType($_GET['id'], Helper::PRACTICAL);
    $labs = $crepo->getClassesBySubjectIdAndType($_GET['id'], Helper::LAB);
} else {
    header('Location: subjects.php');
    die();
}

/**
 * @param array $classes
 * @param ClassRepository $crepo
 * @return string
 */
function prepareClasses(array $classes, ClassRepository $crepo): string
{

    $lectureStruct = "";
    foreach ($classes as $lecture) {
        $signedUp = $crepo->isUserAlreadySignedUp($_SESSION['user'], $lecture['id']);
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
                        <h2>$lecture[teacher]</h2>
                        <p>$lecture[location]</p>
                        ";
        if ($signedUp) {
            $lectureStruct .= "<form action='subjectsignoff.php' method='post'>";
        } else {
            $lectureStruct .= "<form action='subjectsignup.php' method='post'>";
        }

        $lectureStruct .= "
                            <input type='hidden' name='student' value='$_SESSION[user]'>
                            <input type='hidden' name='class' value='$lecture[id]'>
                            <input type='hidden' name='detail' value='$_GET[id]'>
                            ";
        if ($signedUp) {
            $lectureStruct .= "<input type='submit' value='Odhlásit' >";
        } else {
            $lectureStruct .= "<input type='submit' value='Zapsat' >";
        }

        $lectureStruct .= "</form>
                    </section>
        </div>";
    }
    return $lectureStruct;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($subject['code']) ?> - Detail</title>
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
                        <?= $subjectDetails['lectures'] > 0 ? 1 : 0 ?>P+
                        <?= $subjectDetails['practicals'] > 0 ? 1 : 0 ?>C+
                        <?= $subjectDetails['labs'] > 0 ? 1 : 0 ?>L
                    </p>
                    <p>Dostupné paralelky předmětu:
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
                    echo "<fieldset>" .
                        "<legend>Přednášky</legend>" .
                        prepareClasses($lectures, $crepo) .
                        "</fieldset>";
                }
                if ($practicals) {
                    echo "<fieldset>" .
                        "<legend>Cvičení</legend>" .
                        prepareClasses($practicals, $crepo) .
                        "</fieldset>";
                }
                if ($labs) {
                    echo "<fieldset>" .
                        "<legend>Laboratoře</legend>" .
                        prepareClasses($labs, $crepo) .
                        "</fieldset>";
                }
                ?>
            </article>
        </div>
    </section>
</div>
</body>
</html>
