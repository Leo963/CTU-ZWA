<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Problém s databází</title>
    <link rel="stylesheet" href="css/dberr.css">
</head>
<body>
<h1>Omlouváme se za problém.</h1>
<h2>Nepodařilo se navázat spojení s databází</h2>
<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    echo "<form action='$url'>
<input type='submit' value='Zkusit znovu'>
</form>";
}
?>
</body>
</html>