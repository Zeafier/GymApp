<?php
session_start();
include'dbconnection.php';
include("checklogin.php");
include "functions/XSS.php";
check_login();

$citname = "";
$postcode = "";
$street = "";
$posts = array();

$_SESSION['msg']="";
//Update selected postcode
if(isset($_POST['Submit']))
{
    $postcode=clean($_POST['postcode']);
    $street=clean($_POST['street']);
    $ciid = clean($_POST['city']);
    if (empty($postcode) || empty($street) || empty($ciid)){
        $_SESSION['msg']="One of the field is empty";
    }else{
        $stmnt = $con -> prepare("UPDATE _address_ SET _cID_=?, _Street_ = ? WHERE _Postcode_ = ?");
        $stmnt -> bind_param("iss", $ciid, $street, $postcode);
        if($stmnt->execute()){
            $_SESSION['msg']="Address updated successfully";
            $stmnt->close();
        }else{
            $_SESSION['msg']="Something went wrong. Try again";
            $stmnt->close();
        }   
    }
}
//Remove selected postcode
if(isset($_POST['Remove']))
{
    $postcode=clean($_POST['postcode']);
    $stmnt = $con -> prepare("DELETE FROM _address_ WHERE _Postcode_ = ?");
    $stmnt -> bind_param("s", $postcode);
    if($stmnt->execute()){
        $_SESSION['msg']="Address Removed successfully";
        $stmnt->close();
    }else{
        $_SESSION['msg']="Something went wrong. Try again";
        $stmnt->close();
    }
}
//Display selected postcode
if(isset($_POST["post-search"])){
            $post = clean($_POST["post-search"]);
            $sql = $con->prepare("Select _c_name_, _Postcode_, _Street_ FROM _address_ JOIN _city_ ON _city_._cID_ = _address_._cID_ WHERE _Postcode_ = ?");
            $sql -> bind_param("s", $post);
            $sql -> execute();
            $sql -> bind_result($citname, $postcode, $street);
            if(!$sql -> fetch()){
                $_SESSION['msg']="Address not found";
                $sql->close();
            }else{
                $sql->close();
            }
}
//Find postcode
if(isset($_POST["Search"])){
    $ins = clean($_POST['post']);
    $param = "%{$ins}%";
      $msg = $con -> prepare("Select _Postcode_ FROM _address_ JOIN _city_ ON _city_._cID_ = _address_._cID_ WHERE _Postcode_ LIKE ?");
      $msg -> bind_param("s", $param);
      $msg -> execute(); 
      $msg -> bind_result($pos);
      if(!$msg->num_rows < 0){
          echo "<script>alert('Postcode not found')</script>";
      }else{
          while($msg->fetch()){
              $posts[] = $pos;
          }
          $msg -> close();
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
      <!-- Search for postcode -->
      <section id="main-content">
          <section class="wrapper">
              <center><form class="form-horizontal style-form" name="search" method="post" action="" onSubmit="return valid();"> 
                  <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                <h3>Type postcode:</h3>
              <input type="text" name="post" maxlength="7">
              <button type="submit" class="btn btn-theme04" name="Search">Search</button>
              </form> </center>
          </section>  
      </section>
      <!-- Search for postcode -->
      <!-- Display postcodes in combobox -->
       <section id="main-content">
          <section class="wrapper">
              <form class="form-horizontal style-form" name="search" method="post" action="" onSubmit="return valid();"> 
                  <center><h3>Choose postcode:</h3></center>
                  <div id="mainselection">
                    <?php
                      if(empty($posts)){
                          ?>
                      <select name="post-search" id="post-search">
                        <option value="">Find address first*</option>
                      </select>
                          <?php }else{
                            echo '<select name="post-search" id="post-search" onchange="this.form.submit();">';
                            echo '<option value="">Select*</option>';
                            foreach($posts as $value){
                                print '<option value="'.$value.'">'.$value.'</option>';
                            }
                          echo '</select>';
                      }
                        ?>
                  </div>
              </form>
          </section>  
      </section>
      <!-- Display postcodes in combobox -->
      <!-- Display postcodes for editing/removing -->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> <?php print $postcode;?>'s Information</h3>
             	
				<div class="row"> 
                  <div class="col-md-12">
                      <div class="content-panel">
                      
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Postcode </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="postcode" required maxlength="45" readonly value="<?php print $postcode;?>" >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Street name</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="street" maxlength="45" required value="<?php print $street;?>" >
                              </div>
                          </div>
                          
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">City</label>
                              <div class="col-sm-10">
                                  <?php 
                                    if ($citname!=""){
                                        $stmnt = $con -> prepare("Select * FROM _city_ GROUP BY _c_name_");
                                        $stmnt -> execute();
                                        $stmnt -> bind_result($id, $city_n);
                                        echo '<select class="form-control" name="city">';
                                        while ($stmnt->fetch()) {
                                            if($citname == $city_n){
                                                echo '<option selected value="'.$id.'">'.$city_n.'</option>';
                                            }else{
                                                echo '<option value="'.$id.'">'.$city_n.'</option>';   
                                            }
                                        }
                                        echo '</select>';
                                        $stmnt->close();
                                        }else{
                                        echo '<select class="form-control" name="city">';
                                        echo '<option selected value="'.$citname.'">'.$citname.'</option>';
                                        echo '</select>';
                                    }
                                  ?>
                              </div>
                          </div>
                          <div style="margin-left:100px;">
                            <input type="submit" name="Submit" value="Update" class="btn btn-theme04">
                            <input type="submit" name="Remove" style="margin-left:1000px;" value="Remove" class="btn btn-theme04" onClick="return confirm('Do you really want to delete');">
                           </div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
      </section>
      <!-- Display postcodes for editing/removing -->
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
