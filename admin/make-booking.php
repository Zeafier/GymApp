<?php
session_start();
include 'dbconnection.php';
include 'checklogin.php';
include "functions/XSS.php";
check_login();

$_SESSION['msg'] = "";
$_uda = clean($_GET["uid"]);
$name;

/* Book class for user */
if(isset($_POST['book_class'])){
    $class_id = clean($_POST['classes']);
    $cdate = clean($_POST['bday']);
    $newDate = date("Y-m-d", strtotime($cdate));
    $a=date('Y-m-d'); 
    $vnull = null;
    $ic = 1;
    $stmnt = $con -> prepare("SELECT COUNT(_class_id_) AS 'counter' FROM _user_class_ WHERE _class_id_ = ? AND _date_ = ? AND _is_confirmed_ = 1");
    $stmnt -> bind_param("sd", $class, $cdate);
    $stmnt -> execute();
    $stmnt -> bind_result($counter);
    if($stmnt -> fetch()){
        $stmnt -> close(); 
        if($newDate < $a){
            $_SESSION['msg'] = 'Incorrect date.';
        }else if($counter > 5){
            $_SESSION['msg'] ='No available space. Please choose another date';
        }else if($class_id == ""){
            $_SESSION['msg'] ='Please choose class.';
        }else{
            $stmnt1 = $con -> prepare("SELECT _cu_ID_ FROM _user_class_ WHERE _class_id_= ? AND _user_ID_ = ? AND _date_ = ? AND _is_confirmed_ = 1");
            $stmnt1 -> bind_param("iis", $class_id, $_uda, $newDate);
            $stmnt1 -> execute();
            if($stmnt1 -> fetch()){
                $_SESSION['msg'] ='User already posses booking for choosen class and date.';
                $stmnt1->close();
            }else{
                $stmnt1->close();
                $stmnt2 = $con -> prepare("INSERT INTO _user_class_(_class_id_,_cu_ID_,_user_ID_,_date_,_is_confirmed_) VALUES(?, ?, ?, ?, ?);");
                $stmnt2 -> bind_param("siiss", $class_id, $vnull, $_uda, $newDate, $ic);
                if($stmnt2 -> execute()){
                    $_SESSION['msg'] = 'The booking is successful';
                }else{
                    $_SESSION['msg'] = 'Something went wrong. Please try again.';
                }   
            }
        }
    }
}
/* Book personal trainer for user */
if(isset($_POST['book_trainer'])){
    $t_id = clean($_POST['Trainer']);
    $c_id = clean($_POST['classes']);
    $cdate = clean($_POST['bday']);
    $newDate = date("Y-m-d", strtotime($cdate));
    $a=date('Y-m-d'); 
    $vnull = null;
    $ic = 1;
    $stmnt = $con -> prepare("SELECT COUNT(_btID_) AS 'counter' FROM _book_trainer WHERE _tID_ = ? AND _bDATE_ = ? AND _is_confirm_ = 1");
    $stmnt -> bind_param("sd", $t_id, $cdate);
    $stmnt -> execute();
    $stmnt -> bind_result($counter);
    if($stmnt -> fetch()){
        $stmnt->close();   
        if($newDate < $a){
            $_SESSION['msg'] = 'Incorrect date';
        }else if($counter > 1){
            $_SESSION['msg'] = 'Personal trainer is booked for this date. Choose another date';
        }else if($t_id == "" || $c_id == ""){
            $_SESSION['msg'] = 'Please choose one of the option';
        }else{
            $stmnt1 = $con -> prepare("SELECT _btID_ FROM _book_trainer WHERE _uID_ = ? AND _bDATE_ = ? AND _is_confirm_ = ?");
            $stmnt1 -> bind_param("iss", $_uda, $newDate, $ic);
            $stmnt1 -> execute();
            if($stmnt1 -> fetch()){
                echo "<script>alert('You already booked your trainer for this date. Go to MANAGE to change your booking');</script>";
                $stmnt1->close();
            }else{
                $stmnt1->close();
                $stmnt2 = $con -> prepare("INSERT INTO _book_trainer(_tID_,_btID_,_cID_,_bDATE_,_uID_,_is_confirm_) VALUES(?, ?, ?, ?, ?, ?);");
                $stmnt2 -> bind_param("iiisis", $t_id, $vnull, $c_id, $newDate, $_uda, $ic);
                if($stmnt2 -> execute()){
                    $_SESSION['msg'] = 'The booking is successful';
                }else{
                    $_SESSION['msg'] = 'Something went wrong. Please try again.';
                }   
            }
        }
    }
}

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Make User's Booking</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body onload="openBook(event, 'Class')">

  <section id="container" >
      <!-- Navigation -->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="manage-users.php" class="logo"><b>Admin Dashboard</b></a>
            <div class="nav notify-row" id="top_menu">  
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!-- Navigation -->
      <!-- Site Navigation -->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="#"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php echo $_SESSION['login'];?></h5>
              	  	
                  <li class="mt">
                      <a href="change-password.php">
                          <i class="fa fa-file"></i>
                          <span>Change Password</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="manage-users.php" >
                          <i class="fa fa-users"></i>
                          <span>Manage Users</span>
                      </a>
                   
                  </li>
              
                 <li class="sub-menu">
                      <a href="add-user.php" >
                          <i class="fa fa-users"></i>
                          <span>Create user</span>
                      </a>
                   
                  </li>
                  
                  <li class="sub-menu">
                      <a href="manage-bookings.php" >
                          <i class="fa fa-file"></i>
                          <span>Manage Bookings</span>
                      </a>
                   
                  </li>
                  
                  
                  <li class="sub-menu">
                      <a href="manage-address.php" >
                          <i class="fa fa-file"></i>
                          <span>Manage addresses</span>
                      </a>
                   
                  </li>
                  
              </ul>
          </div>
      </aside>
      <!-- Site Navigation -->
      
       <!-- Find user -->
      <?php
        if(isset($_GET["uid"]) && is_numeric($_GET['uid'])){
            $id = clean($_GET['uid']);
            $sql = $con -> prepare("SELECT _fn_ FROM _users_ WHERE _uID_ = ? ");
            $sql -> bind_param("i", $id);
            $sql -> execute();
            $sql -> bind_result($name);
            if($sql->fetch()){
                $sql -> close();
            }else{
                echo "<p>User Not Found</p>";
            }
        }else{
            echo "<p>Invalid user</p>";
        }
      ?>
      <!-- Find user -->
        <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Book for <?php print $name;?></h3>
            </section>
      </section>
      
      <!-- Bookings -->
      <section id="main-content">
          <section class="wrapper">
          	<div class="container">
                <center><h2>Bookings</h2></center>
                    <!-- Select Bookings -->
                    <div class="tab">
                      <button class="tablinks" onclick="openBook(event, 'Class')">Book class</button>
                      <button class="tablinks" onclick="openBook(event, 'Trainer')">Book trainer</button>
                    </div>
                    <!-- Select Bookings -->
                <!-- Bookings Class -->
                    <div id="Class" class="tabcontent">
                        <div class="book_class" id="book_class">
                            <p align="center" style="color:#F00;"><?php print $_SESSION['msg'];?><?php print $_SESSION['msg']=""; ?></p>
                            <form class="form-horizontal style-form" name="Class-booking" method="post" action="" onSubmit="return valid();">
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
                                <input type="submit" name="book_class" style="margin-left: 47%; margin-top:15px;" value="Book" class="btn btn-theme04">
                            </form>
                        </div>
                    </div>
                <!-- Bookings Class -->
                
                <!-- Bookings Personal trainer -->
                    <div id="Trainer" class="tabcontent">
                        <div class="book_class" id="personal_class">
                            <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
                            <form class="form-horizontal style-form" name="Personal-booking" method="post" action="" onSubmit="return valid();">
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
                                <input type="submit" name="book_trainer" style="margin-left: 47%; margin-top:15px;" value="Book" class="btn btn-theme04">
                        </form>
                    </div>
                </div>
                <!-- Bookings Personal trainer -->
            </div>
		</section>
      </section>
      <!-- Bookings -->
  </section>
      
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
  <script>
      $(function(){
          $('select.styled').customSelect();
      });

  </script>
      
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

  </body>
</html>
