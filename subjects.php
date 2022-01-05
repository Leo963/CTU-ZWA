<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Předměty</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/subjects.css">
</head>
<body>
<?php
require_once 'init.php';
include 'header.php';

/**
 * Clamps an integer value between max and min values
 * @param int $value Value to be clamped
 * @param int $min Lower bound inclusive
 * @param int $max Upper boudn inclusive
 * @return int Clamped value
 */
function clamp(int $value, int $min, int $max): int
{
    return max($min, min($max, $value));
}

?>
<div class="content">

    <?php include 'nav.php' ?>
    <section class="main">
        <h2>Dostupné předměty</h2>
        <div class="sub-list">

            <header>
                <h3 class='code'>Kód
                    <a href="<?= $_SERVER['REQUEST_URI'] . "&casc=1" ?>">&and;</a>
                    <a href="<?= $_SERVER['REQUEST_URI'] . "&casc=0" ?>">&or;</a>
                </h3>
                <h3 class='code'>Jméno
                    <a href="<?= $_SERVER['REQUEST_URI'] . "&nasc=1" ?>">&and;</a>
                    <a href="<?= $_SERVER['REQUEST_URI'] . "&nasc=0" ?>">&or;</a>
                </h3>
            </header>
            <section class="list">
                <?php

                const ITEMS_PER_PAGE = 5;
                $srepo = new SubjectRepository($dataLayer);
                $maxItems = $srepo->countSubjects();
                $pages = ceil($maxItems / ITEMS_PER_PAGE);

                /**
                 * @param $srepo
                 * @param int $offset
                 * @return mixed
                 */
                function prepareOrder(&$srepo, int $offset = null) {
                    $orderby = [];
                    $dir = [];
                    if (isset($_GET['casc']) || isset($_GET['nasc'])) {
                        if (isset($_GET['casc'])) {
                            array_push($orderby, "code");
                            if ($_GET['casc'] == 0) {
                                array_push($dir, "DESC");
                            } else {
                                array_push($dir, "ASC");
                            }
                        }
                        if (isset($_GET['nasc'])) {
                            array_push($orderby, "name");
                            if ($_GET['nasc'] == 0) {
                                array_push($dir, "DESC");
                            } else {
                                array_push($dir, "ASC");
                            }
                        }
                        if ($offset != null) {
                            return $srepo->getPaginatedSubjectsOrdered($dir, $orderby, $offset);
                        }
                        return $srepo->getPaginatedSubjectsOrdered($dir, $orderby);
                    } else {
                        if ($offset != null) {
                            return $srepo->getPaginatedSubjects($offset);
                        }
                        return $srepo->getPaginatedSubjects();
                    }
                }

                if (!isset($_GET['page'])) {
                    $subjects = prepareOrder($srepo);
                    $_GET['page'] = 1;
                } elseif (is_numeric($_GET['page'])) {
                    $subjects = prepareOrder($srepo,(clamp($_GET['page'], 1, $pages) - 1) * ITEMS_PER_PAGE);
                } else {
                    $subjects = prepareOrder($srepo);
                    $_GET['page'] = 1;
                }

                foreach ($subjects as $subject) {
                    echo "<article class='subject'>
                    <h3 class='code'>$subject[code]</h3>
                    <h3 class='name'>$subject[name]</h3>
                    <form action='detail.php'>
                    <button class='detail' name='id' value='$subject[id]'>Detail</button>
                    </form>
                </article>";
                }
                ?>
            </section>
            <nav>
                <?php
                $navStruct = "";
                if ($_GET['page'] == 1) {
                    // "&laquo; &lsaquo;"  "&rsaquo; &raquo;"
                    $navStruct .= "<a href='?page=1'> &laquo; </a> <a href='?page=1'> &lsaquo; </a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page']) . "'>" . ($_GET['page']) . "</a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page'] + 1) . "'>" . ($_GET['page'] + 1) . "</a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page'] + 2) . "'>" . ($_GET['page'] + 2) . "</a>";

                    if ($_GET['page'] + 2 == $pages - 1) {
                        $navStruct .= "<a href='?page=$pages'> $pages </a>";
                    }
                    if ($_GET['page'] + 2 < $pages - 1) {
                        $navStruct .= " ...";
                        $navStruct .= "<a href='?page=$pages'> $pages </a>";
                    }

                    $navStruct .= "<a href='?page=" . ($_GET['page'] + 1) . "'> &rsaquo; </a> <a href='?page=$pages'> &raquo; </a>";
                } elseif ($_GET['page'] == $pages) {
                    $navStruct .= "<a href='?page=1'> &laquo; </a> <a href='?page=" . ($_GET['page'] - 1) . "'> &lsaquo; </a>";

                    if ($_GET['page'] - 1 > 2) {
                        $navStruct .= "<a href='?page=1'>1</a>";
                        $navStruct .= " ...";
                    }

                    $navStruct .= "<a href='?page=" . ($_GET['page'] - 2) . "'>" . ($_GET['page'] - 2) . "</a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page'] - 1) . "'>" . ($_GET['page'] - 1) . "</a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page']) . "'>" . ($_GET['page']) . "</a>";
                    $navStruct .= "<a href='?page=$pages'> &rsaquo; </a> <a href='?page=$pages'> &raquo; </a>";
                } else {
                    $navStruct .= "<a href='?page=1'> &laquo; </a> <a href='?page=" . ($_GET['page'] - 1) . "'> &lsaquo; </a>";
                    if ($_GET['page'] - 1 == 2) {
                        $navStruct .= "<a href='?page=1'>1</a>";
                    }
                    if ($_GET['page'] - 1 > 2) {
                        $navStruct .= "<a href='?page=1'>1</a>";
                        $navStruct .= " ...";
                    }
                    $navStruct .= "<a href='?page=" . ($_GET['page'] - 1) . "'>" . ($_GET['page'] - 1) . "</a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page']) . "'>" . ($_GET['page']) . "</a>";
                    $navStruct .= "<a href='?page=" . ($_GET['page'] + 1) . "'>" . ($_GET['page'] + 1) . "</a>";

                    if ($_GET['page'] + 1 == $pages - 1) {
                        $navStruct .= "<a href='?page=$pages'> $pages </a>";
                    }
                    if ($_GET['page'] + 1 < $pages - 1) {
                        $navStruct .= " ...";
                        $navStruct .= "<a href='?page=$pages'> $pages </a>";
                    }

                    $navStruct .= "<a href='?page=" . ($_GET['page'] + 1) . "'> &rsaquo; </a> <a href='?page=$pages'> &raquo; </a>";
                }
                echo $navStruct;
                ?>
            </nav>
        </div>
    </section>
</div>
</body>
</html>