<?php
session_start();
include "checker/checklogin.php";
include "checker/dbconnection.php";
include "admin/functions/XSS.php";
check_login();
$counter;
$val = 5;

if(isset($_POST['book_class'])){
    $class_id = clean($_POST['classes']);
    $cdate = clean($_POST['bday']);
    $newDate = date("Y-m-d", strtotime($cdate));
    $a=date('Y-m-d'); 
    $vnull = null;
    $ic = 1;
    $stmnt = $con -> prepare("SELECT COUNT(_class_id_) AS 'counter' FROM _user_class_ WHERE _class_id_ = ? AND _date_ = ? AND _is_confirmed_ = 1");
    $stmnt -> bind_param("is", $class_id, $newDate);
    $stmnt -> execute();
    $stmnt -> bind_result($counter);
    if($stmnt -> fetch()){
        $stmnt -> close(); 
        if($newDate < $a){
            echo "<script>alert('Incorrect date.');</script>";
        }else if($counter >= $val){
            echo "<script>alert('No available space. Please choose another date');</script>";
        }else if($class_id == "" || empty($newDate)){
            echo "<script>alert('Please choose class or date.');</script>";
        }else{
            $stmnt1 = $con -> prepare("SELECT _cu_ID_ FROM _user_class_ WHERE _class_id_= ? AND _user_ID_ = ? AND _date_ = ? AND _is_confirmed_ = 1");
            $stmnt1 -> bind_param("iis", $class_id, $_SESSION['id'], $newDate);
            $stmnt1 -> execute();
            if($stmnt1 -> fetch()){
                echo "<script>alert('You already choosen this activity for choosen date. Go to MANAGE to change your booking');</script>";
                $stmnt1->close();
            }else{
                $stmnt1->close();
                $stmnt2 = $con -> prepare("INSERT INTO _user_class_(_class_id_,_cu_ID_,_user_ID_,_date_,_is_confirmed_) VALUES(?, ?, ?, ?, ?);");
                $stmnt2 -> bind_param("siiss", $class_id, $vnull, $_SESSION['id'], $newDate, $ic);
                if($stmnt2 -> execute()){
                    echo "<script>alert('The booking is successful');</script>";
                }else{
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                }   
            }
        }
    }
}

if(isset($_POST['book_trainer'])){
    $t_id = clean($_POST['Trainer']);
    $c_id = clean($_POST['classes']);
    $cdate = clean($_POST['bday']);
    $newDate = date("Y-m-d", strtotime($cdate));
    $a=date('Y-m-d'); 
    $vnull = null;
    $ic = 1;
    $stmnt = $con -> prepare("SELECT _btID_ FROM _book_trainer WHERE _tID_ = ? AND _bDATE_ = ? AND _is_confirm_ = 1");
    $stmnt -> bind_param("is", $t_id, $cdate);
    $stmnt -> execute();
    if($stmnt -> fetch()){   
        echo "<script>alert('Personal trainer is booked for this date. Choose another date');</script>";
        $stmnt->close();
    }else{
        $stmnt->close(); 
        if($newDate < $a){
            echo "<script>alert('Incorrect date');</script>";
        }else if($t_id == "" || $c_id == ""){
            echo "<script>alert('Please choose one of the option');</script>";
        }else{
            $stmnt1 = $con -> prepare("SELECT _btID_ FROM _book_trainer WHERE _uID_ = ? AND _bDATE_ = ? AND _is_confirm_ = ?");
            $stmnt1 -> bind_param("iss", $_SESSION['id'], $newDate, $ic);
            $stmnt1 -> execute();
            if($stmnt1 -> fetch()){
                echo "<script>alert('You already booked your trainer for this date. Go to MANAGE to change your booking');</script>";
                $stmnt1->close();
            }else{
                $stmnt1->close();
                $stmnt2 = $con -> prepare("INSERT INTO _book_trainer(_tID_,_btID_,_cID_,_bDATE_,_uID_,_is_confirm_) VALUES(?, ?, ?, ?, ?, ?);");
                $stmnt2 -> bind_param("iiisis", $t_id, $vnull, $c_id, $newDate, $_SESSION['id'], $ic);
                if($stmnt2 -> execute()){
                    echo "<script>alert('The booking is successful');</script>";
                }else{
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                }   
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="author" content="Roehampton">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book </title>
    <link rel="stylesheet" href="css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href="../Assignment/css/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    
    
</head>
<body onload="openBook(event, 'Class')">

   <nav>
        <div class="wrapper-menu">
            <ul>
                <a href="welcome.php"><div class="logo"></div></a>
                <li><a href="welcome.php" class="active">Home</a></li>
                <li><a href="#" class="active"><?php echo $_SESSION['login'];?></a></li>
                <div class="bt-login">
                    <a href="logout.php"><button type="submit">Logout</button></a>
                </div>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <center><h2>Bookings</h2></center>
        <!-- Tabs buttons -->
        <div class="tab">
          <button class="tablinks" onclick="openBook(event, 'Class')">Book class</button>
          <button class="tablinks" onclick="openBook(event, 'Trainer')">Book trainer</button>
        </div>
        
        <!-- Class container -->
        <div id="Class" class="tabcontent">
            <div class="book_class" id="book_class">
                <form name="Class-booking" method="post" action="">
                    <center><h3>New class booking</h3></center>
                    <p>Class</p>
                    <div id="mainselection">
                        <?php
                               $sql=$con->prepare("Select _cID_,_Class_name_ from _class_ GROUP BY _Class_name_ ");    
                                $sql->execute();
                                $sql->bind_result($class_id, $classname);
                                echo '<select name="classes" id="classes">';
                                echo '<option value="">Select*</option>';
                                while($sql->fetch()){
                                   echo '<option value="'.$class_id.'">'.$classname.'</option>';
                                }
                                echo '</select>';
                            ?>
                    </div>
                    <p>Date</p>
                    <center><input type="date" name="bday" required></center>
                    <div class="Book-button">
                        <input type="submit" name="book_class"  value="Book">
                    </div>
                </form>
            </div>
        </div>

        <!-- Trainer container -->
        <div id="Trainer" class="tabcontent">
            <div class="book_class" id="personal_class">
                <form name="Personal-booking" method="post" action="">
                    <center><h3>New Private session</h3></center>
                    <p>Trainer</p>
                    <div id="mainselection">
                        <?php
                               $sql=$con->prepare("Select _pID_,_pFN_, _pLN_ from _personal_trainer_ GROUP BY _pLN_");    
                                $sql->execute();
                                $sql->bind_result($P_id, $P_name, $P_sur);
                                echo '<select name="Trainer" id="Trainer">';
                                echo '<option value="">Select*</option>';
                                while($sql->fetch()){
                                   echo '<option value="'.$P_id.'">'.$P_name.' '.$P_sur.'</option>';
                                }
                                echo '</select>';
                            ?>
                    </div>
                    <p>Training class</p>
                    <div id="mainselection">
                        <?php
                               $sql=$con->prepare("Select _cID_,_Class_name_ from _class_ GROUP BY _Class_name_ ");    
                                $sql->execute();
                                $sql->bind_result($class_id, $classname);
                                echo '<select name="classes" id="classes">';
                                echo '<option value="">Select*</option>';
                                while($sql->fetch()){
                                   echo '<option value="'.$class_id.'">'.$classname.'</option>';
                                }
                                echo '</select>';
                            ?>
                    </div>
                    <p>Date</p>
                    <center><input type="date" name="bday" required></center>
                    <div class="Book-button">
                        <input type="submit" name="book_trainer"  value="Book">
                    </div>
                </form>
            </div>
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
    <!-- Sript for moving tabs -->
    <script>
    function openBook(evt, className) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(className).style.display = "block";
      evt.currentTarget.className += " active";
    }
    </script>
    <!-- Sript for moving tabs -->
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>