<?php
require_once 'init.php';

const VALID = 0;
const SHORTUSERNAME = 1;
const SHORTPASSWORD = 2;
const TOOYOUNG = 4;

$badValue = VALID;


/**
 * Validates
 * @param $badValue int Reference to bad value
 * @return bool If values passed validation
 */
function validate(int &$badValue) :bool
{
    $currDate = new DateTime('now');
    if (strlen($_POST['username']) < 6) {
        $badValue |= SHORTUSERNAME;
        return false;
    }
    if (strlen($_POST['pass']) < 8) {
        $badValue |= SHORTPASSWORD;
        return false;
    }
    if (date_create_from_format('Y-m-d',$_POST['dob'])->diff($currDate)->y <=14) {
        $badValue |= TOOYOUNG;
        return false;
    }
    return true;
}

$users = new UserRepository($dataLayer);
if (
       isset(
           $_POST['fname'],
           $_POST['lname'],
           $_POST['dob'],
           $_POST['username'],
           $_POST['pass']
       )
) {
    if(validate($badValue)){
        $users->createUser(
            $_POST['fname'],
            $_POST['lname'],
            $_POST['dob'],
            $_POST['username'],
            password_hash($_POST['pass'],PASSWORD_BCRYPT)
        );
        header('Location: landing.php');
        die();
    }
}


?>
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
        <?php
        if ($badValue != VALID)
            echo "<div class='error'>";
                if ($badValue & SHORTUSERNAME)
                    echo "<h3>Příliš krátké uživatelské jméno</h3>";
                if ($badValue & SHORTPASSWORD)
                    echo "<h3>Příliš krátké heslo</h3>";
                if ($badValue & TOOYOUNG)
                    echo "<h3>Tato služba je dostupná až od 15 let</h3>";
            echo "</div>"
        ?>
        <fieldset>
            <legend>Osobní údaje</legend>
            <label>
                Jméno
                <input type="text" name="fname" id="fname" required
                       value="<?php if(isset($_POST['fname'])) echo htmlspecialchars($_POST['fname']) ?>">
            </label>
            <label>
                Příjmení
                <input type="text" name="lname" id="lname" required
                       value="<?php if(isset($_POST['lname'])) echo htmlspecialchars($_POST['lname']) ?>">
            </label>
            <label>
                Datum narození
                <input type="date" name="dob" id="dob" required
                       value="<?php if(isset($_POST['dob'])) echo htmlspecialchars($_POST['dob']) ?>">
            </label>
        </fieldset>
        <fieldset>
            <legend>Přihlašovací údaje</legend>
            <label class="optional">
                Email
                <input type="email" name="email" id="email"
                       value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']) ?>">
            </label>
            <label>
                Uživatelské jméno
                <input type="text" name="username" id="username" required
                       value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']) ?>">
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