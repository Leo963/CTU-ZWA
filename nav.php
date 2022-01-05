    <nav>
        <ul>
            <?php
            if (!strpos($_SERVER['PHP_SELF'],'admin/')) {
                echo '
            <li><a href="landing.php">Úvod</a></li>
            <li><a href="subjects.php">Předměty</a></li>
            ';
                if (isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)) {
                    echo '<li>Administrace</li>'.
                        '<li>'.
                        '<ul>'.
                        '<li><a href="admin/subjects.php">Předměty</a></li>'.
                        '<li><a href="admin/students.php">Studenti</a></li>'.
                        '</ul>'.
                        '</li>'
                    ;
                }
            }
            else {
                echo '
            <li><a href="../landing.php">Úvod</a></li>
            <li><a href="../subjects.php">Předměty</a></li>
            <li><a href="../grades.php">Známky</a></li>
            ';
                if (isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)) {
                    echo '<li>Administrace</li>'.
                        '<li>'.
                        '<ul>'.
                        '<li><a href="subjects.php">Předměty</a></li>'.
                        '<li><a href="students.php">Studenti</a></li>'.
                        '</ul>'.
                        '</li>'
                    ;
                }
            }

            ?>
        </ul>
    </nav> 