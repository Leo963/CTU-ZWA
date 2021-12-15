<header class="page">
    <h1>SOP</h1>
    <h2><a href="user.php"><?php
            if(isset($_SESSION['user'])) {
                $user = $urepo->getUser($_SESSION['user']);
                echo htmlspecialchars($user["fname"] . " " . $user["lname"]);
            }
            ?></a>
        <a href="logout.php">Odhlásit se</a>
    </h2>
</header>