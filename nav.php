    <nav>
        <ul>
            <li><a href="landing.php">Úvod</a></li>
            <li><a href="subjects.php">Předměty</a></li>
            <li><a href="grades.php">Známky</a></li>
            <?php
            if (isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)) {
                echo '<li><a href="admin/index.php">Známky</a></li>';
            }
            ?>
        </ul>
    </nav> 