<header class="page">
    <h1>SOP</h1>
    <h2><a href="user.php"><?php
            if(isset($_SESSION['user'])) {
                $user = $users->getUser($_SESSION['user']);
                echo htmlspecialchars($user["fname"] . " " . $user["lname"]);
            }
            ?></a>
        <?php
        if (strpos($_SERVER['PHP_SELF'],'admin/')) {
            echo '<a href="../logout.php">Odhlásit se</a>';
        }
        else {
            echo '<a href="logout.php">Odhlásit se</a>';
        }

        ?>
    </h2>
</header>