<?php
session_start();
include 'dbconnection.php';
include 'checklogin.php';
include "functions/XSS.php";
check_login();

$_SESSION['msg'] = "";
$date;
$name;
$classID;
$counter;

/* Update user's class */
if(isset($_POST['Update01'])){
    if(!empty($_POST['chid'])){
        //check if checkboxes were ticked
        foreach($_POST['chid'] as $chid){
            $chid = clean($chid);
            $stmnt = $con->prepare("Select _date_ FROM _user_class_ where _cu_ID_ = ?");
            $stmnt -> bind_param("i", $chid);
            $stmnt -> execute();
            $stmnt -> bind_result($date);
            //check if booking exists
            if ($stmnt -> fetch()){
                $stmnt -> close();
                $cdate = $_POST[$date];
                $a=date('Y-m-d');
                $newDate = date("Y-m-d", strtotime($cdate));

                $stmnt = $con->prepare("Select _class_id_ FROM _user_class_,_class_ WHERE _cu_ID_= ? AND _user_class_._class_id_=_class_._cID_");
                $stmnt -> bind_param("i", $chid);
                $stmnt -> execute();
                $stmnt -> bind_result($classID);
                if ($stmnt -> fetch()){
                    $stmnt -> close();

                    $stmnt = $con -> prepare("SELECT COUNT(_class_id_) AS 'counter' FROM _user_class_ WHERE _class_id_ = ? AND _date_ = ?");
                    $stmnt -> bind_param("sd", $classID, $newDate);
                    $stmnt -> execute();
                    $stmnt -> bind_result($counter);
                    if($stmnt -> fetch()){
                        $stmnt->close();
                        if($cdate == $date){
                            $_SESSION['msg'] = "Date matching older date";
                        }else if($cdate < $a){
                            $_SESSION['msg'] = "Incorrect date";
                        }else if($counter > 5){
                            $_SESSION['msg'] = "Choosen date is not available";
                        }else{
                            $query = $con->prepare("Update _user_class_ SET _date_ = ? WHERE _cu_ID_ = ?");
                            $query->bind_param("si",$newDate, $chid);
                            if($query->execute()){
                                $query->close();
                                $_SESSION['msg'] = "Items updated successfully";
                            }else{
                                $query->close();
                                $_SESSION['msg'] = "Something went wrong ";
                            }
                        }
                    }
                }
            }
        }
    }else{
        $_SESSION['msg'] = "No items selected";
    }   
}

/* Update user's personal trainer */
if(isset($_POST['Update02'])){
    if(!empty($_POST['chid'])){
        foreach($_POST['chid'] as $chid){
            $chid = clean($chid);
            $stmnt = $con->prepare("Select _bDATE_ FROM _book_trainer where _btID_ = ?");
            $stmnt -> bind_param("i", $chid);
            $stmnt -> execute();
            $stmnt -> bind_result($date);
            if ($stmnt -> fetch()){
                $stmnt -> close();
                $cdate = $_POST[$date];
                $a=date('Y-m-d');
                $newDate = date("Y-m-d", strtotime($cdate));

                $stmnt = $con->prepare("Select _tID_ FROM _book_trainer WHERE _btID_= ?");
                $stmnt -> bind_param("i", $chid);
                $stmnt -> execute();
                $stmnt -> bind_result($classID);
                if ($stmnt -> fetch()){
                    $stmnt -> close();

                    $stmnt = $con -> prepare("SELECT COUNT(_btID_) AS 'counter' FROM _book_trainer WHERE _tID_ = ? AND _bDATE_ = ? AND _is_confirm_ = 1");
                    $stmnt -> bind_param("sd", $classID, $newDate);
                    $stmnt -> execute();
                    $stmnt -> bind_result($counter);
                    if($stmnt -> fetch()){
                        $stmnt->close();
                        if($cdate == $date){
                            $_SESSION['msg'] = "Date matching older date";
                        }else if($cdate < $a){
                            $_SESSION['msg'] = "Incorrect date";
                        }else if($counter > 1){
                            $_SESSION['msg'] = "Trainer is not available for that day";
                        }else{
                            $query = $con->prepare("Update _book_trainer SET _bDATE_ = ? WHERE _btID_ = ?");
                            $query->bind_param("si",$newDate, $chid);
                            if($query->execute()){
                                $_SESSION['msg'] = "Items updated successfully";
                                $query->close();
                            }else{
                                $_SESSION['msg'] = "Something went wrong ";
                                $query->close();
                            }
                        }
                    }
                }
            }
        }
    }
}

/* Remove user's class */
if(isset($_POST['Remove01'])){
    if(!empty($_POST['chid'])){
        foreach($_POST['chid'] as $chid){
            $chid = clean($chid);
            $stmnt = $con->prepare("UPDATE _user_class_ SET _is_confirmed_ = 0 WHERE _cu_id_ = ?");
            $stmnt -> bind_param("i", $chid);
            if($stmnt -> execute()){
                $_SESSION['msg'] = "Successfully removed data";
            }else{
                $_SESSION['msg'] = "Something went wrong";
            } 
        }
    }else{
        $_SESSION['msg'] = "No items selected";
    }   
}
/* Remove user's personal trainer */
if(isset($_POST['Remove02'])){
    if(!empty($_POST['chid'])){
        foreach($_POST['chid'] as $chid){
            $chid = clean($chid);
            $stmnt = $con->prepare("UPDATE _book_trainer SET _is_confirm_ = 0 WHERE _btID_ = ?");
            $stmnt -> bind_param("i", $chid);
            if($stmnt -> execute()){
                $_SESSION['msg'] = "Successfully removed data";
            }else{
                $_SESSION['msg'] = "Something went wrong";
            } 
        }
    }else{
        $_SESSION['msg'] = "No items selected";
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

    <title>Admin | Manage Users</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

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
      <!-- Side Navigation -->
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
      <!-- Side Navigation -->
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
      <!-- Choose user's type action -->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Manage <?php print $name;?>'s bookings</h3>
				<div class="row">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px; font-size: 16px;">Select:</label>
                          <form id="select" name="select" method="POST">
                              <div class="select">
                                  <select id="type" name="type" onchange="this.form.submit();">
                                      <option value="">Select*</option>
                                    <option value="class">Class</option>
                                    <option value="personal">Personal Trainer</option>    
                                  </select>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
              <!-- Choose user's type action -->
              <!-- Edit or remove user's booking -->
              <div class="row">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                              <?php include "functions/get-details.php";?>
                          </form>
                      </div>
                  </div>
              </div>
              <!-- Edit or remove user's booking -->
		</section>
      </section>
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

  </body>
</html>
