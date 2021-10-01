<?php
session_start();
include "checker/checklogin.php";
include "checker/dbconnection.php";
include "admin/functions/XSS.php";
check_login();

$classID;
$counter;
$date;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="author" content="Roehampton">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage bookings </title>
    <link rel="stylesheet" href="css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href="../Assignment/css/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
    <script>
        function deleletconfig(){

        var del=confirm("Are you sure you want to delete this records?");
        if (del==true){
            <?php 
              if(isset($_POST['rbID'])){
                  $ids = clean($_POST['rbID']);
                $query = $con->prepare("Update _user_class_ SET _is_confirmed_ = 0 WHERE _cu_ID_ = ?");
                $query->bind_param("i",$ids);
                $query->execute();
                $query->close();
            }
            if(isset($_POST['rtID'])){
                $tids = clena($_POST['rtID']);
                $query = $con->prepare("Update _book_trainer SET _is_confirm_ = 0 WHERE _btID_ = ?");
                $query->bind_param("i",$tids);
                $query->execute();
                $query->close();
            }
          ?>
        alert ("Records deleted.");
        }
            return del;
        }
    </script>
    
</head>
<body onload="openBook(event, 'Class')">

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
        
    
    <!-- START SECTION -->
  		<div class="section text-center background-dark dark-bg">
  			<div class="manage-image" style="background: url(images/booking.jpg) no-repeat fixed center; background-size: cover; opacity: .2;"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-uppercase letter-spacing-md font-weight-lg margin-zero">Manage your bookings</h3>
                    </div>
                </div>
            </div>   
  		</div>
  		<!--/.section -->
    
        <div class="container">
            <div class = "tab">
                <h3>Your bookings</h3>
                <form name="manage" id="manage" method="post">
                    <select name="type">
                        <option value="1">Current bookings</option>
                        <option value="2">Past bookings</option>
                    </select>
                
                    <div id="mainselection">
                        <select name="booking">
                            <option value="">Select booking type*</option>
                            <option value="1">Classes</option>
                            <option value="2">Personal trainer</option>
                        </select>
                    </div>
                    
                    <input class="btn btn-primary" style="float: right; margin-right:5px; margin-bottom:5px;" type="submit" name="check_class" value="Check" />
                </form>
                <form action = "manage.php" name="update" id="update" method="POST">
                    <?php include "getValues.php" ?>
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