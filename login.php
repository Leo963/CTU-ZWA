<?php
require_once 'init.php';

$badLogin = 0;

$users = new UserRepository($dataLayer);
if (
    isset(
        $_POST['username'],
        $_POST['pass']
    )
) {
    $return = $users->getUserPassword($_POST['username']);

    if(isset($return) && password_verify($_POST['pass'],$return)) {
        $_SESSION['user'] = $_POST['username'];
        header('Location: landing.php');
        die();
    } else {
        $badLogin = 1;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="js/login.js"></script>
</head>
<body>
<form action="" method="post" id="login">
    <header>
        <h1>Přihlášení</h1>
    </header>
    <main>
        <?php
        if ($badLogin === 1)
            echo "<div class='error'>
                <h3>Špatné jméno nebo heslo</h3>
            </div>"
        ?>
        <label>
            Uživatelské jméno
            <input type="text" name="username" id="username" value="<?php if (isset($_POST['username']))
                echo htmlspecialchars($_POST['username'])?>" required>
        </label>
        <label>
            Heslo
            <input type="password" name="pass" id="pass" required>
        </label>
        <input type="submit" value="Přihlásit">
    </main>
    <footer>
        <a href="signup.php">Nemáte účet? Zaregistrujte se</a>
    </footer>
</form>
</body>
</html>