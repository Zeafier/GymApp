<?php
session_start();
include'dbconnection.php';
include("checklogin.php");
include "functions/XSS.php";
check_login();
$_SESSION['msg'] = "";
$id = $_SESSION['id'];

/* Change admin password */
if(isset($_POST['Submit']))
{
    $old = clean($_POST['oldpass']);
    $new = clean($_POST['newpass']);
    $new2 = clean($_POST['confirmpassword']);
    $id = clean($_SESSION['id']);
    if(empty($old) || empty($new) || empty($new2)){
        echo "<script>alert('Please fill all of the gaps')</script>";
    }else if($new != $new2){
        echo "<script>alert('Passwords do not match')</script>";
    }else if(!preg_match( '~[A-Z]~', $new) || !preg_match( '~[a-z]~', $new) || !preg_match( '~\d~', $new)){
        echo "<script>alert('Password must contain at least one small letter, one big letter and one number')</script>";
    }else if(strlen($new) < 6 || strlen($new) > 15){
        echo "<script>alert('Passwords must be between 6-15 characters')</script>";
    }else{
        $sql = $con -> prepare("SELECT _pw_ FROM _users_ WHERE _uID_ = ?");
        $sql -> bind_param("s", $id);
        $sql -> execute();
        $sql -> bind_result($current);
        if($sql -> fetch()){
            if(password_verify($old, $current)){
                $sql -> close();
                $hpw = password_hash($new, PASSWORD_BCRYPT);
                $stmnt = $con->prepare("UPDATE _users_ SET _pw_ = ? WHERE _uID_ = ?");
                $stmnt -> bind_param("si", $hpw, $id);
                if ($stmnt -> execute()){
                    $_SESSION['msg']="Password Changed Successfully !!";
                    $stmnt -> close();
                }
            }else{
                $_SESSION['msg']="Old Password not match !!";
                $sql -> close();
            }
        }else{
            $_SESSION['msg']="Something went wrong!!";
        }
    }
}
?>
<script language="javascript" type="text/javascript">
    function valid()
    {
        if(document.form1.oldpass.value=="")
    {
        alert(" Old Password Field Empty !!");
        document.form1.oldpass.focus();
        return false;
    }
        else if(document.form1.newpass.value=="")
    {
        alert(" New Password Field Empty !!");
        document.form1.newpass.focus();
        return false;
    }
        else if(document.form1.confirmpassword.value=="")
    {
        alert(" Re-Type Password Field Empty !!");
        document.form1.confirmpassword.focus();
        return false;
    }
        else if(document.form1.newpass.value.length<6)
    {
        alert(" Password Field length must be atleast of 6 characters !!");
        document.form1.newpass.focus();
        return false;
    }
        else if(document.form1.confirmpassword.value.length<6)
    {
        alert(" Re-Type Password Field less than 6 characters !!");
        document.form1.confirmpassword.focus();
        return false;
    }
        else if(document.form1.newpass.value!= document.form1.confirmpassword.value)
    {
        alert("Password and Re-Type Password Field do not match  !!");
        document.form1.newpass.focus();
        return false;
    }
        return true;
    }
</script>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Change Password</title>
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
      <!-- Site Navigation -->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="manage-users.php"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
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
      <!-- Change password -->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Change Password </h3>
				<div class="row"> 
                  <div class="col-md-12">
                      <div class="content-panel">
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Old Password</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" maxlength="45" name="oldpass" value="" required>
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">New Password</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" maxlength="45" name="newpass" value="" required>
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Confirm Password</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" maxlength="45" name="confirmpassword" value="" required>
                              </div>
                          </div>
                          <div style="margin-left:100px;">
                          <input type="submit" name="Submit" value="Change" class="btn btn-theme04"></div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
      </section>
      <!-- Change password -->
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
