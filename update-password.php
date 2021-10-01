<?php
session_start();
include "checker/checklogin.php";
include "checker/dbconnection.php";
include "admin/functions/XSS.php";
check_login();

$_SESSION['msg'] = "";
$id = clean($_SESSION['id']);

/* Change password */
if(isset($_POST['Change_password']))
{
    $old = clean($_POST['old']);
    $newpass = clean($_POST['new']);
    $newpass2 = clean($_POST['new2']);
    if(empty($newpass) || empty($newpass2) || empty($old)){
        echo "<script>alert('Please fill all of the gaps')</script>";
    }else if($newpass != $newpass2){
        echo "<script>alert('Passwords do not match')</script>";
    }else if(!preg_match( '~[A-Z]~', $newpass) || !preg_match( '~[a-z]~', $newpass) || !preg_match( '~\d~', $newpass)){
        echo "<script>alert('Password must contain at least one small letter, one big letter and one number')</script>";
    }else if(strlen($newpass) < 6 || strlen($newpass) > 15){
        echo "<script>alert('Passwords must be between 6-15 characters')</script>";
    }else{
        $sql = $con -> prepare("SELECT _pw_ FROM _users_ WHERE _uID_ = ?");
        $sql -> bind_param("s", $_SESSION['id']);
        $sql -> execute();
        $sql -> bind_result($current);
        if($sql -> fetch()){
            if(password_verify($old, $current)){
                $sql -> close();
                $hpw = password_hash($newpass, PASSWORD_BCRYPT);

                $stmnt = $con->prepare("UPDATE _users_ SET _pw_ = ? WHERE _uID_ = ?");
                $stmnt -> bind_param("si", $hpw, $id);
                if ($stmnt -> execute()){
                    echo "<script>alert('Password was changed successfully')</script>";
                    $stmnt -> close();
                }
            }else{
                echo "<script>alert('Your old password is incorrect')</script>";
                $sql -> close();
            }
        }else{
            echo "<script>alert('Something went wrong. Try again')";
        }
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="author" content="Roehampton">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change password </title>
    <link rel="stylesheet" href="css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href="../Assignment/css/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet"> <!--load all styles -->
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="wrapper-menu">
            <ul>
                <a href="welcome.php"><div class="logo"></div></a>
                <li><a href="welcome.php" class="active">Home</a></li>
                <li><a href="#" class="active"><?php print $_SESSION['login'];?></a></li>
                <div class="bt-login">
                    <a href="logout.php"><button type="submit">Logout</button></a>
                </div>
            </ul>
        </div>
    </nav>
    <!-- Navigation -->
    
    <div class="container">    
        <div class="change-password" style="background-color:gainsboro; padding: 6px 12px; border: 1px solid #ccc; border-top: none;">
            <form name="Change_password" method="post" action="">
                <center><h2>Change password</h2></center>
                <p style="text-align: center; text-transform: uppercase; margin-top: 5%;">Old password</p>
                <center><input type="password" class="text" value="" style="width:400px; text-align: center;" name="old" maxlength="25" required></center>
                <p style="text-align: center; text-transform: uppercase; margin-top: 5%;">New password</p>
                <center><input type="password" class="text" value="" style="width:400px; text-align: center;" name="new" maxlength="25" required></center>
                <p style="text-align: center; text-transform: uppercase; margin-top: 5%;">Confirm password</p>
                <center><input type="password" class="text" value="" style="width:400px; text-align: center;" name="new2" maxlength="25" required></center>
                <div class="Book-button">
                    <input type="submit" name="Change_password"  value="Book">
                </div>
            </form>
        </div>
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