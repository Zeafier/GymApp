<?php
session_start();
include('dbconnection.php');
include("checklogin.php");
include ("functions/XSS.php");
check_login();

$_SESSION['msg'] = "";
$fname=""; $lname=""; $email=""; $contact=""; $nh=""; $postcode=""; $sname="";
//Create new user
if(isset($_POST['Create']))
{
    //check variables
    $type = clean($_POST['type']);
    $cityid=clean($_POST['city']);
	$fname=clean($_POST['fname']);
	$lname=clean($_POST['lname']);
	$email=clean($_POST['email']);
	$password=clean($_POST['pass']);
	$contact=clean($_POST['contact']);
    $postcode=clean($_POST['postcode']);
    $nh=clean($_POST['house']);
    $sname=clean($_POST['street']);
    $r_p=clean($_POST['rpass']);
    $vnull = null;
    //hash password
    $hpw = password_hash($password, PASSWORD_BCRYPT);
    $a=date('Y-m-d'); 
    //Fing email in database
    $stmnt = $con->prepare("Select _em_ From _users_ Where _em_ = ?");
    $stmnt->bind_param("s",$email);
    $stmnt->execute();    
    
    //check fields
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($contact) || empty($postcode) || empty($nh) || empty($sname)){
        $_SESSION['msg'] = "Please fill all the fields";
        $stmnt -> close();
        //check if user exists
    }else if($stmnt->fetch()!=0){
        $_SESSION['msg'] = 'User account already exists';
        $stmnt -> close();
        //check if passwords match
    }else if($password != $r_p){
        $_SESSION['msg'] = 'Passwords mismatch. Try again';
        $stmnt -> close();
        //check if password have secure lenght
    }else if(strlen($password) < 5 || strlen($password) > 15){
        $_SESSION['msg'] = 'Passwords must have 5-15 characters';
        $stmnt -> close();
        //check if email is correct
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['msg'] = 'Invalid email address.';
        $stmnt -> close();
        //check if number is correct
    }else if(!filter_var($contact, FILTER_VALIDATE_INT)){
        $_SESSION['msg'] = 'Invalid number phone.';
        $stmnt -> close();
    }else{
        //Proceed creating of user
        $msg = "Select _Postcode_ FROM _address_ WHERE _Postcode_ = ?;";
        $stmnt1 = $con->prepare($msg);
        $stmnt1 -> bind_param("s", $postcode);
        $stmnt1 -> execute();
        if($stmnt1->fetch()!=0){
            $stmnt1 -> close();
            $stmnt2 = $con->prepare("INSERT INTO _users_ (_uID_, _pw_, _posting_date_, _postcode_, _h_number_, _ln_, _fn_, _em_, _contactno_, _is_admin_) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmnt2 -> bind_param("isssssssis", $vnull, $hpw, $a, $postcode, $nh, $lname, $fname, $email, $contact, $type);
            if($stmnt2 -> execute()){
                $_SESSION['msg'] = 'Your account has been created.';
                $fname=""; $lname=""; $email=""; $contact=""; $nh=""; $postcode=""; $sname="";
                $stmnt2 -> close();
            }else{
                $_SESSION['msg'] = 'Something went wrong. Please try again.';
            }
            //Proceed creating user if address do not exists
        }else{
            $stmnt4 = $con -> prepare("INSERT INTO _address_ (_cID_, _Postcode_, _Street_) VALUES (?, ?, ?)");
            $stmnt4 -> bind_param("sss", $cityid, $postcode, $sname);
            if($stmnt4 -> execute()){
                $stmnt4 -> close();
                $stmnt5 = $con->prepare("INSERT INTO _users_ (_uID_, _pw_, _posting_date_, _postcode_, _h_number_, _ln_, _fn_, _em_, _contactno_, _is_admin_) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmnt5 -> bind_param("isssssssis", $vnull, $hpw, $a, $postcode, $nh, $lname, $fname, $email, $contact, $type);
                if($stmnt5 -> execute()){
                    $_SESSION['msg'] = 'Your account has been created.';
                    $fname=""; $lname=""; $email=""; $contact=""; $nh=""; $postcode=""; $sname="";
                    $stmnt5 -> close();
                }else{
                    $_SESSION['msg'] = 'Something went wrong. Please try again.';
                }
            }else{
                $_SESSION['msg'] = 'City not selected.';
            }   
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Create Profile</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>
      <!-- Navigation -->
  <section id="container" >
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="#" class="logo"><b>Admin Dashboard</b></a>
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

      <!-- Create new user -->
      <section id="main-content">
          <section class="wrapper">
          	<h3><center>Add New user</center></h3>
				<div class="row">   
                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
                          <!-- Creating form -->
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                               <!-- Choose user type -->
                           <div class="form-group">
                               <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Type </label>
                               <div class="col-sm-10">
                                  <select class="form-control" name="type">
                                      <option value="0">User</option>
                                      <option value="1">Admin</option>
                                   </select>
                               </div>
                          </div>
                               <!-- Type name -->
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">First Name </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="fname" maxlength="45" value="<?php echo $fname;?>" required>
                              </div>
                          </div>
                          <!-- Type surname -->
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Last Name</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="lname" maxlength="45" value="<?php echo $lname;?>" required>
                              </div>
                          </div>
                          <!-- Type email -->
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Email </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="email" value="<?php echo $email;?>" required>
                              </div>
                          </div>
                               <!-- Type contact number -->
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Contact no. </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="11" name="contact" value="<?php echo $contact;?>" required>
                              </div>
                          </div>
                               <!-- Type postcode -->
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Postcode</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="7" name="postcode" value="<?php echo $postcode;?>" required>
                              </div>
                          </div>
                               <!-- Type street -->
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Street</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="street" maxlength="90" value="<?php echo $sname;?>" required>
                              </div>
                          </div>
                               <!-- Choose city -->
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">City</label>
                              <div class="col-sm-10">
                                  <?php 
                                    $stmnt = $con -> prepare("Select * FROM _city_ GROUP BY _c_name_");
                                    $stmnt -> execute();
                                    $stmnt -> bind_result($id, $city_n);
                                    echo '<select class="form-control" name="city">';
                                    while ($stmnt->fetch()) {
                                        echo '<option value="'.$id.'">'.$city_n.'</option>';   
                                    }
                                    echo '</select>';
                                    $stmnt->close();
                                  ?>
                              </div>
                          </div>
                               <!-- Type house number -->
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">House number</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="house" maxlength="5" value="<?php echo $nh;?>" required>
                              </div>
                          </div>
                                <!-- Password -->
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Password </label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" name="pass" value="" required>
                              </div>
                          </div>
                               <!-- Confirm -->
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Confirm password </label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" name="rpass" value="" required>
                              </div>
                          </div>
                               <!-- Execute -->
                          <div style="margin-left:300px;">
                          <input type="submit" name="Create" value="Create" class="btn btn-theme04"></div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
      </section>
      </section>
      <!-- Create new user -->
      
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
