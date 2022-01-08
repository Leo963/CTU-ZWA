<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrace - Předměty</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/admin.js"></script>
</head>
<body>
<?php
require_once '../init.php';

$urepo = new UserRepository($dataLayer);
$srepo = new SubjectRepository($dataLayer);
$crepo = new ClassRepository($dataLayer);

/**
 * @param array $subjects
 * @return string
 */
function generateSubjects(array $subjects): string
{
    $subjectStruct = "";

    foreach ($subjects as $subject) {
        $subjectStruct .= "<tr>";
        $subjectStruct .= "<td>$subject[code]</td>";
        $subjectStruct .= "<td>$subject[name]</td>";
        if ($subject['length'] == 1) {
            $subjectStruct .= "<td>$subject[length] týden</td>";
        } elseif ($subject['length'] < 5) {
            $subjectStruct .= "<td>$subject[length] týdny</td>";
        } else {
            $subjectStruct .= "<td>$subject[length] týdnů</td>";
        }

        $subjectStruct .= "<td><form action='subjectDetail.php' method='get'>
<input type='hidden' name='id' value='$subject[id]'>
<input type='submit' value='Detail'>
</form></td>";
        $subjectStruct .= "</tr>";
    }

    return $subjectStruct;
}

include '../header.php';

$subjects = $srepo->getAllSubjectsWithDetails();

?>
<div class="content">
    <?php include_once '../nav.php' ?>
    <section class="main">
        <h2>Předměty</h2>
        <table>
            <thead>
            <tr>
                <th>Kód</th>
                <th>Název</th>
                <th>Délka</th>
                <th>Detail</th>
            </tr>
            <tr>
                <th>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <label><input type="text" list="suggestedCodes" name="code-search"<?php
                            if (isset($_POST['code-search'])) echo "value=" . htmlspecialchars($_POST['code-search']);
                            ?>></label>
                        <input type="submit" value="Hledat">
                    </form>
                </th>
                <th>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <label><input type="text" list="suggestedNames" name="name-search"<?php
                            if (isset($_POST['name-search'])) echo "value=" . htmlspecialchars($_POST['name-search']);
                            ?>></label>
                        <input type="submit" value="Hledat">
                        <datalist id="suggestedCodes">
                            <?php
                            foreach ($subjects as $subject) {
                                echo "<option value='$subject[code]'>";
                            }
                            ?>
                        </datalist>
                        <datalist id="suggestedNames">
                            <?php
                            foreach ($subjects as $subject) {
                                echo "<option value='$subject[name]'>";
                            }
                            ?>
                        </datalist>
                    </form>
                </th>
                <th></th>
                <th id="newSubject"><a href="newSubject.php">Nový předmět</a></th>
            </tr>
            </thead>
            <tbody>
            <?php

            if (isset($_POST['code-search']) || isset($_POST['name-search'])) {
                if (isset($_POST['code-search'])) {
                    $subjects = $srepo->getSubjectsCodeSearch($_POST['code-search']);
                } elseif (isset($_POST['name-search'])) {
                    $subjects = $srepo->getSubjectsNameSearch($_POST['name-search']);
                }
            }

            echo generateSubjects($subjects);
            ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>