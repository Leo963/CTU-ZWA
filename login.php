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
        <label>
            Uživatelské jméno
            <input type="text" name="username" id="username" required>
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