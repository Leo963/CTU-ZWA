<?php
require_once '../init.php';

$crepo = new ClassRepository($dataLayer);

$crepo->deleteClassAndSignOff($_POST['class']);

header("Location: subjectDetail.php?id=".$_POST['class']);