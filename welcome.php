<?php
session_start();
include "checker/checklogin.php";
include "checker/dbconnection.php";
check_login();
	
?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="author" content="Roehampton">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome </title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href="../Assignment/css/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet"> <!--load all styles -->
</head>
<body>
    <header>
        <!-- Navigation -->
        <nav>
            <div class="wrapper-menu">
                <a href="index.html">
                    <div class="logo"></div>
                </a>
                <ul>
                    <li><a href="welcome.php" class="active">Home</a></li>
                    <li><a href="#" class="active"><?php print $_SESSION['login'];?></a></li>
                </ul>
                <div class="bt-login">
                    <a href="logout.php"><button type="submit">Logout</button></a>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="container">
        <header class="jumbotron hero-spacer">
            <h1><center>Welcome <?php print $_SESSION['name']; ?>!</center></h1>
            <center><p>Choose today's service:</p></center>
            <div class="row">
                <center><p><a  href="Book.php" class="btn btn-primary btn-large" style="width: 250px;">Book class</a></p></center>
                <center><p><a  href="manage.php" class="btn btn-primary btn-large" style="width: 250px;">Manage your bookings </a></p></center>
                <center><p><a  href="findavailable.php" class="btn btn-primary btn-large" style="width: 250px;">Check availibility </a></p></center>
                <center><p><a  href="update-password.php" class="btn btn-primary btn-large" style="width: 250px;">Change password </a></p></center>
            </div>
        </header>
    </div>
    
    <!--Footer-->
    <div class="footer-distributed">
        <h3> Check our services </h3>
        <div class="footer-left">
            <div class="footer-company-name">
                Wellness4All
            </div>
            <div class="footer-links">
                <a href="http://webpolicy.org/">Policy </a><br>
                <a href="https://www.pagecloud.com/blog/website-terminology">Terms </a><br>
                <a href="https://us.norton.com/internetsecurity-how-to-what-are-cookies.html">Cookies </a><br>
                <a href="#">FAQ </a><br>
            </div>
        </div>
        <div class="footer-center">
                <i>About us</i>
                <p>At The Wellness4All, fitness fits around you – not the other way around. <br>
                    We offer the best quality Les Mills virtual spin classes, access to over a qualified personal trainers and a world-class, friendly gym team. And all of that for amazing value.</p>
        </div>
        <div class="footer-right">
            <h2>Contact us</h2>
            <a>(+44)0700 300 400</a><br>
            <div class="email"><a href = "mailto:W4A@wellness.co.uk">W4A@wellness.co.uk</a></div><br>
            <a>Wellness 4 All, 281 Prince Regent Ln, Plaistow, London E13 8SD</a>
        </div>
        <div class="footer-icons">
            <a href="https://www.facebook.com/roehamptonuni/"><img src="images/fb.png" alt="Facebook"></a>
            <a href="https://twitter.com/roehamptonuni"><img src="images/twt.png" alt="Facebook"></a>
        </div>
        <div class="footer-company-about">
            * Participating gyms only. ** 24 hour access not currently available. Please see individual Gym pages for further details. †Applicable terms, conditions and joining fees may apply. © 2019 Wellness4All.
        </div>
    </div>
    <!--Footer-->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
