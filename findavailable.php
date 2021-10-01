<?php
session_start();
include "checker/checklogin.php";
include "checker/dbconnection.php";
include "admin/functions/XSS.php";
check_login();
$cl = "Class";
$tr = "Trainer";


$val = 5;
if(isset($_POST["classes"])){
    if(!$_POST["bday"]){
        $date=date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($date));
        $class = clean($_POST["classes"]);
        $stmnt = $con -> prepare("SELECT COUNT(_class_id_) AS 'counter' FROM _user_class_ WHERE _class_id_ = ? AND _date_ = ? AND _is_confirmed_ = 1");
        $stmnt -> bind_param("is", $class, $newDate);
        $stmnt -> execute();
        $stmnt -> bind_result($counter);
        if($stmnt->fetch()){
            if($counter >= $val){
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&class=$class&msg");
            }else{
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&class=$class&val=$counter");
            }
        }
    }else{
        $date = clean($_POST["bday"]);
        $newDate = date("Y-m-d", strtotime($date));
        $class = clean($_POST["classes"]);
        $stmnt = $con -> prepare("SELECT COUNT(_class_id_) AS 'counter' FROM _user_class_ WHERE _class_id_ = ? AND _date_ = ? AND _is_confirmed_ = 1");
        $stmnt -> bind_param("is", $class, $newDate);
        $stmnt -> execute();
        $stmnt -> bind_result($counter);
        if($stmnt->fetch()){
            if($counter >= $val){
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&class=$class&msg");
            }else{
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&class=$class&val=$counter");
            }
        }
    }
}

if(isset($_POST["Trainer"])){
    if(!$_POST["bday"]){
        $date=date('Y-m-d');
        $newDate = date("Y-m-d", strtotime($date));
        $train = clean($_POST["Trainer"]);
        $stmnt = $con -> prepare("SELECT COUNT(_btID_) AS 'counter' FROM _book_trainer WHERE _tID_ = ? AND _bDATE_ = ? AND _is_confirm_ = 1");
        $stmnt -> bind_param("is", $train, $newDate);
        $stmnt -> execute();
        $stmnt -> bind_result($counter);
        if($stmnt->fetch()){
            if($counter >= 1){
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&trainer=$train&msg1");
            }else{
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&trainer=$train&val1=$counter");
            }
        }
    }else{
        $date = clean($_POST["bday"]);
        $newDate = date("Y-m-d", strtotime($date));
        $train = clean($_POST["Trainer"]);
        $stmnt = $con -> prepare("SELECT COUNT(_btID_) AS 'counter' FROM _book_trainer WHERE _tID_ = ? AND _bDATE_ = ? AND _is_confirm_ = 1");
        $stmnt -> bind_param("is", $train, $newDate);
        $stmnt -> execute();
        $stmnt -> bind_result($counter);
        if($stmnt->fetch()){
            if($counter >= 1){
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&trainer=$train&msg1");
            }else{
                header("Location: ../Assignment/findavailable.php?find=true&date=$date&trainer=$train&val1=$counter");
            }
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

    <title>Find available </title>
    <link rel="stylesheet" href="css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href="../Assignment/css/fontawesome-free-5.9.0-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    
</head>
<body onload="openBook(event, '<?php if(isset($_GET['trainer'])){echo $tr;}else{echo $cl;} ?>')">
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
    
    <!--Choosing buttons--> 
    <div class="container">
        <center><h2>Check Availability</h2></center>
        <div class="tab">
          <button class="tablinks" onclick="openBook(event, 'Class')">Classes</button>
          <button class="tablinks" onclick="openBook(event, 'Trainer')">Trainers</button>
        </div>
        <!--Choosing buttons--> 
        
        <!--Classes--> 
        <div id="Class" class="tabcontent">
            <div class="book_class" id="book_class">
                <form name="Class-booking" method="post" action="">
                    <center><h3>Classes</h3></center>
                    <p>Class</p>
                    <div id="mainselection">
                        <?php
                            if(isset($_GET['class'])){
                                $cclass = clean($_GET['class']);
                                $sql=$con->prepare("Select _cID_,_Class_name_ from _class_ GROUP BY _Class_name_ ");    
                                $sql->execute();
                                $sql->bind_result($class_id, $classname);
                                echo '<select name="classes" id="classes" onchange="this.form.submit();">';
                                while($sql->fetch()){
                                    if($cclass == $class_id){
                                        echo '<option selected value="'.$class_id.'">'.$classname.'</option>';
                                    }else{
                                        echo '<option value="'.$class_id.'">'.$classname.'</option>';   
                                    }
                                }
                                echo '</select>';
                            }else{
                                $sql=$con->prepare("Select _cID_,_Class_name_ from _class_ GROUP BY _Class_name_ ");    
                                $sql->execute();
                                $sql->bind_result($class_id, $classname);
                                echo '<select name="classes" id="classes" onchange="this.form.submit();">';
                                while($sql->fetch()){
                                   echo '<option value="'.$class_id.'">'.$classname.'</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                    </div>
                    <p>Date</p>
                    <?php
                    if(isset($_GET["date"])){
                        $date = clean($_GET["date"]);
                        echo '<center><input type="date" name="bday" value="'.$date.'" onchange="this.form.submit();" required></center>'; 
                    }else{
                        echo '<center><input type="date" name="bday" onchange="this.form.submit();" required></center>';   
                    }
                    
                    if(isset($_GET["msg"])){
                        echo '<p><font color="red">NOT AVAILABLE</font></p>';
                    }
                    if(isset($_GET["val"])){
                        $res=clean($_GET["val"]);
                        if(is_numeric($res)){
                            $val=5-$res;
                            echo '<p><font color="green">AVAILABLE '.$val.' spaces</font></p>';
                        }else{
                            echo '<p><font color="red">NOT AVAILABLE</font></p>';
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
         <!--Classes-->       

        
        <!--Trainer classes-->
        <div id="Trainer" class="tabcontent">
            <div class="book_class" id="personal_class">
                <form name="Personal-booking" method="post" action="">
                    <center><h3>Trainers</h3></center>
                    <p>Trainer</p>
                    <div id="mainselection">
                        <?php
                            if(isset($_GET['trainer'])){
                                $cclass = clean($_GET['trainer']);
                               $sql=$con->prepare("Select _pID_,_pFN_, _pLN_ from _personal_trainer_ GROUP BY _pLN_");    
                                $sql->execute();
                                $sql->bind_result($P_id, $P_name, $P_sur);
                                echo '<select name="Trainer" id="Trainer" onchange="this.form.submit();">';
                                while($sql->fetch()){
                                    if($cclass == $P_id){
                                        echo '<option selected value="'.$P_id.'">'.$P_name.' '.$P_sur.'</option>';
                                    }else{
                                        echo '<option value="'.$P_id.'">'.$P_name.' '.$P_sur.'</option>';
                                    }
                                }
                                echo '</select>';
                            }else{
                                $sql=$con->prepare("Select _pID_,_pFN_, _pLN_ from _personal_trainer_ GROUP BY _pLN_");    
                                $sql->execute();
                                $sql->bind_result($P_id, $P_name, $P_sur);
                                echo '<select name="Trainer" id="Trainer" onchange="this.form.submit();">';
                                while($sql->fetch()){
                                   echo '<option value="'.$P_id.'">'.$P_name.' '.$P_sur.'</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                    </div>
                    <p>Date</p>
                    <?php
                    if(isset($_GET["date"])){
                        $date = clean($_GET["date"]);
                        echo '<center><input type="date" name="bday" value="'.$date.'" onchange="this.form.submit();" required></center>'; 
                    }else{
                        echo '<center><input type="date" name="bday" onchange="this.form.submit();" required></center>';   
                    }
                    
                    if(isset($_GET["msg1"])){
                        echo '<p><font color="red">TRAINER NOT AVAILABLE</font></p>';
                    }
                    if(isset($_GET["val1"])){
                        $res=clean($_GET["val1"]);
                        echo '<p><font color="green">TRAINER IS AVAILABLE</font></p>';
                    }
                    ?>
                </form>
            </div>
        </div>

    </div>
    <!--Trainer classes-->
    
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
`<!-- Script for tabs -->
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
    <!-- Script for tabs -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
