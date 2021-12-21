<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrace</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../js/admin.js"></script>
    <noscript>
        <style>
            #withJS {
                display: none;
            }
        </style>
    </noscript>
</head>
<body>
<?php include '../header.php' ?>
<section class="main">
    <noscript>
        <div>
            <h2>Administrační rozcestník</h2>
            <div class="tab" id="students">
                <h3>Studenti</h3>
                <hr>
                <nav class="admin">
                    <button>Nový student</button>
                </nav>
                <hr>

            </div>
            <div class="tab" id="subjects">
                <h3>Předměty</h3>
            </div>
        </div>
    </noscript>
    <div id="withJS">
        <h2>Administrační rozcestník</h2>
        <div class="tabs">
            <button class="tablink" id="students">Studenti</button>
            <button class="tablink" id="subjects">Předměty</button>
        </div>
        <div class="tab" id="students-tab">
            <h3>Studenti</h3>
            <hr>
            <nav class="admin">
                <button>Nový student</button>
            </nav>
            <hr>
            
        </div>
        <div class="tab" id="subjects-tab">
            <h3>Předměty</h3>
        </div>
    </div>
</section>

</body>
</html>