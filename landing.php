<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landing page</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/landing.css" media="screen">
    <link rel="stylesheet" href="css/print-landing.css" media="print">
</head>
<body>
<?php include 'header.html'?>
<div class="content">
    <?php include 'nav.html'?>
    <section class="main">
        <h4>Dnes je datum</h4>
        <article>
            <header>
                <h2>Nadcházející</h2>
            </header>
            <div class="lessons">
                <div class="lesson">
                    <header>
                        <h2>ZWA</h2>
                        <span><time>11:00</time>-<time>12:30</time></span>
                    </header>
                    <section class="lesson">
                        <h2>Základy webových aplikací</h2>
                        <p>T2:D3-209</p>
                    </section>
                </div>
                <div class="lesson">
                    <header>
                        <h2>ZWA</h2>
                        <span><time>11:00</time>-<time>12:30</time></span>
                    </header>
                    <section class="lesson">
                        <h2>Základy webových aplikací</h2>
                        <p>KN:E-310</p>
                    </section>
                </div>
                <div class="lesson"></div>
                <div class="lesson"></div>
            </div>
        </article>
        <article>
            <header>
                <h2>Aktuality</h2>
            </header>
        </article>
    </section>
</div>


</body>
</html>