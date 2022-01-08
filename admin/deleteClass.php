<?php
require_once '../init.php';

$crepo = new ClassRepository($dataLayer);

if (isset($_POST['check'])) {
    if ($_POST['check'] == 1) {
        $crepo->deleteClass($_POST['class']);
    }
}
else {
    $crepo->deleteClass($_POST['class']);
}

header("Location: subjectDetail.php?id=".$_POST['subject']);