<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="http://www.myersdaily.org/joseph/javascript/md5.js"></script> <!-- Nápomocná implementace hashe md5 -->
    <script src="js/signup.js"></script>
</head>
<body>
<form action="" method="post" class="signup" id="signup">
    <header>
        <h1>Registrace</h1>
    </header>
    <main>
        <fieldset>
            <legend>Osobní údaje</legend>
            <label>
                Jméno
                <input type="text" name="fname" id="fname" required>
            </label>
            <label>
                Příjmení
                <input type="text" name="lname" id="lname" required>
            </label>
            <label>
                Datum narození
                <input type="date" name="DOB" id="dob" required>
            </label>
        </fieldset>
        <fieldset>
            <legend>Přihlašovací údaje</legend>
            <label>
                Uživatelské jméno
                <input type="text" name="username" id="username" required>
            </label>
            <label>
                Heslo
                <input type="password" name="pass" id="pass" required>
            </label>
        </fieldset>
    </main>
    <footer>
        <input type="submit" value="Registrovat">
        <a href="login.php">Již máte účet? Přihlašte se</a>
    </footer>
</form>
</body>
</html>