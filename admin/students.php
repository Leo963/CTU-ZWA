<?php
require_once '../init.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrace - <?php if ($_SESSION['role'] == 1) echo "Uživatelé"; else echo "Studenti"; ?></title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/admin.js"></script>
</head>
<body>
<?php

$urepo = new UserRepository($dataLayer);


/**
 * @param array $users
 * @return string
 */
function generateUsers(array $users, bool $admin): string
{
    $userStruct = "";

    foreach ($users as $user) {
        $userStruct .= "<tr>";
        $userStruct .= "<td>$user[username]</td>";
        $userStruct .= "<td>$user[fullname]</td>";
        $userStruct .= "<td>$user[dob]</td>";
        if ($admin) {
            $userStruct .= "<td>$user[role]</td>";
        }
        $userStruct .= "<td><form action='userDetail.php' method='post'>
<input type='hidden' name='id' value='$user[id]'>
<input type='submit' value='Detail'>
</form></td>";
        $userStruct .= "</tr>";
    }

    return $userStruct;
}

include '../header.php'
?>
<div class="content">
    <?php include_once '../nav.php' ?>
    <section class="main">
        <h2><?php if ($_SESSION['role'] == 1) echo "Uživatelé"; else echo "Studenti"; ?></h2>
        <table>
            <thead>
            <tr>
                <th>Uživatelské jméno</th>
                <th>Jméno</th>
                <th>Datum Narození</th>
                <?php if ($_SESSION['role'] == 1) echo "<th>Role</th>"; ?>
                <th>Detail</th>
            </tr>
            <tr>
                <th>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <label><input type="text" name="username-search"<?php
                            if (isset($_POST['username-search'])) echo "value=" . htmlspecialchars($_POST['username-search']);
                            ?>></label>
                        <input type="submit" value="Hledat">
                    </form>
                </th>
                <th>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <label><input type="text" name="fullname-search"<?php
                            if (isset($_POST['fullname-search'])) echo "value=" . htmlspecialchars($_POST['fullname-search']);
                            ?>></label>
                        <input type="submit" value="Hledat">
                    </form>
                </th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_POST['username-search']) || isset($_POST['fullname-search'])) {
                if (isset($_POST['username-search'])) {
                    if ($_SESSION['role'] == 1) {
                        $users = $urepo->getUsersUsernameSearch($_POST['username-search']);
                    } else {
                        $users = $urepo->getStudentsUsernameSearch($_POST['username-search']);
                    }
                } elseif (isset($_POST['fullname-search'])) {
                    if ($_SESSION['role'] == 1) {
                        $users = $urepo->getUsersFullnameSearch($_POST['fullname-search']);
                    } else {
                        $users = $urepo->getStudentsFullnameSearch($_POST['fullname-search']);
                    }
                }
            } else {
                if ($_SESSION['role'] == 1) {
                    $users = $urepo->getAllUsers();
                } else {
                    $users = $urepo->getAllStudents();
                }
            }

            echo generateUsers($users, $_SESSION['role'] == 1);
            ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>