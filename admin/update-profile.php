<?php
session_start();
include'dbconnection.php';
include("checklogin.php");
include "functions/XSS.php";
check_login();

$uID = clean($_GET['uid']);
$_SESSION['msg'] = "";

$id; $fn; $ln; $em; $contact; $pd; $post; $st; $cn; $nh;

/* Update users data */
if(isset($_POST['Submit']))
{
	$fname=clean($_POST['fname']);
	$lname=clean($_POST['lname']);
	$contact=clean($_POST['contact']);
    $postcode=clean($_POST['postcode']);
    $street=clean($_POST['street']);
    $ciid = clean($_POST['city']);
    $numbhou = clean($_POST['house']);
    $uid = clean($_GET['uid']);
    if(empty($fname) || empty($lname) || empty($contact) || empty($postcode) || empty($street) || empty($ciid) || empty($numbhou) || empty($uid)){
        $_SESSION['msg']="One of the field is empty";
    }else if(!filter_var($contact, FILTER_VALIDATE_INT)){
        $_SESSION['msg']="Invalid contact number";
    }else{
        $msg = "Select _Postcode_ FROM _address_ WHERE _Postcode_ = ?;";
        $stmnt1 = $con->prepare($msg);
        $stmnt1 -> bind_param("s", $postcode);
        $stmnt1 -> execute();
        if($stmnt1 -> fetch()){
            $stmnt1 -> close();
            $stmnt = $con->prepare("Update _users_ SET _fn_ = ?, _ln_ = ?, _contactno_ = ?, _postcode_ = ?, _h_number_ = ? WHERE _uID_ = ?");
            $stmnt -> bind_param("ssissi", $fname, $lname, $contact, $postcode, $numbhou, $uid);
            if($stmnt -> execute()){
                $_SESSION['msg']="Profile Updated successfully";
                $stmnt->close();
            }else{
                $_SESSION['msg']="Something went wrong";
                $stmnt->close();
            }
        }else{
            $stmnt4 = $con -> prepare("INSERT INTO _address_ (_cID_, _Postcode_, _Street_) VALUES (?, ?, ?)");
            $stmnt4 -> bind_param("sss", $ciid, $postcode, $street);
            if($stmnt4->execute()){
                $stmnt4->close();
                $stmnt = $con->prepare("Update _users_ SET _fn_ = ?, _ln_ = ?, _contactno_ = ?, _postcode_ = ?, _h_number_ = ? WHERE _uID_ = ?");
                $stmnt -> bind_param("ssissi", $fname, $lname, $contact, $postcode, $numbhou, $uid);
                if($stmnt -> execute()){
                    $_SESSION['msg']="Profile Updated successfully";
                    $stmnt->close();
                }else{
                    $_SESSION['msg']="Something went wrong";
                    $stmnt->close();
                }
            }else{
                $_SESSION['msg']="Something went wrong";
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

    <title>Admin | Update Profile</title>
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
      <!-- Side navigation -->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="#"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php print clean($_SESSION['login']);?></h5>
              	  	
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
      <!-- Side navigation -->
      
      <!-- Get users information -->
      <?php 
      $sql = $con->prepare("Select _uID_, _fn_, _ln_, _em_, _contactno_,            _posting_date_,_users_._postcode_,_Street_, _c_name_, _h_number_ FROM _users_ 
      JOIN _address_ ON _address_._Postcode_ = _users_._postcode_ 
      JOIN _city_ ON _city_._cID_=_address_._cID_
      WHERE _uID_ = ? ");
      $sql -> bind_param("i", $uID);
      $sql -> execute();
      $sql -> bind_result($id, $fn, $ln, $em, $contact, $pd, $post, $st, $cn, $nh);
	  if($sql->fetch())
	  {$sql->close(); ?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> <?php print $fn;?>'s Information</h3>
             	
				<div class="row">  
                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php print $_SESSION['msg'];?><?php print $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">First Name </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="fname" maxlength="45" value="<?php print $fn;?>" >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Last Name</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="lname" maxlength="45" value="<?php print $ln;?>" >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Email </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="email" value="<?php print $em;?>" readonly >
                              </div>
                          </div>
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Contact no. </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="11" name="contact" value="<?php print $contact;?>" >
                              </div>
                          </div>
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Postcode</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" maxlength="7" name="postcode" value="<?php print $post;?>" >
                              </div>
                          </div>
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Street</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="street" maxlength="90" value="<?php print $st;?>" >
                              </div>
                          </div>
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">City</label>
                              <div class="col-sm-10">
                                  <?php 
                                    //Select cities from database and display current user's city 
                                    $stmnt = $con -> prepare("Select * FROM _city_ GROUP BY _c_name_");
                                    $stmnt -> execute();
                                    $stmnt -> bind_result($id, $city_n);
                                    echo '<select class="form-control" name="city">';
                                    while ($stmnt->fetch()) {
                                        $id = clean($id);
                                        $city_n = clean($city_n);
                                        if($city_n == $cn){
                                            echo '<option selected value="'.$id.'">'.$city_n.'</option>';
                                        }else{
                                            echo '<option value="'.$id.'">'.$city_n.'</option>';   
                                        }
                                    }
                                    echo '</select>';
                                    $stmnt->close();
                                  ?>
                              </div>
                          </div>
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">House number</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="house" maxlength="5" value="<?php print $nh;?>" >
                              </div>
                          </div>
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Registration Date </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="registration" value="<?php print $pd;?>" readonly>
                              </div>
                          </div>
                          <div style="margin-left:100px;">
                          <input type="submit" name="Submit" value="Update" class="btn btn-theme"></div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
        <?php } ?>
      </section>
      <!-- Get users information -->
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
