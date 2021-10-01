<?php
session_start();
include 'dbconnection.php';
include 'checklogin.php';
include "functions/XSS.php";
check_login();

//Remove user from database
if(isset($_GET['uid']))
{
    $adminid=clean($_GET['uid']);
    $sql = $con -> prepare("DELETE FROM _user_class_ WHERE _user_ID_ = ?");
    $sql -> bind_param("i", $adminid);
    if($sql -> execute()){
        $sql -> close();
        $stmnt = $con->prepare("DELETE FROM _book_trainer WHERE _uID_ = ?");
        $stmnt -> bind_param("i", $adminid);
        if($stmnt -> execute()){
            $stmnt -> close();
            $msg = $con -> prepare("DELETE FROM _users_ WHERE _uID_ = ?");
            $msg -> bind_param("i", $adminid);
            if($msg -> execute()){
                echo "<script>alert('Data deleted');</script>";
            }else{
                echo "<script>alert('Something went wrong');</script>";
            }
        }else{
            echo "<script>alert('Something went wrong');</script>";
        }
    }else{
        echo "<script>alert('Something went wrong');</script>";
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
      <!-- Manage users sector -->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Manage Users</h3>
				<div class="row">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> All User Details </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th>Sno.</th>
                                  <th class="hidden-phone">First Name</th>
                                  <th> Last Name</th>
                                  <th> Email Id</th>
                                  <th>Contact no.</th>
                                  <th>Reg. Date</th>
                              </tr>
                              </thead>
                              <!-- Get data from database -->
                              <tbody>
                                  
                                  <?php 
                                  $cnt=1;
                                  $sql = $con -> prepare("Select _uID_, _fn_, _ln_, _em_, _contactno_, _posting_date_ FROM _users_ WHERE _is_admin_ = 0");
                                  $sql -> execute();
                                  $sql -> bind_result($id, $fn, $ln, $em, $cn, $pd);
                                  while ($sql->fetch())
                                  {?>
                                  <tr>
                                      <td><?php print $cnt;?></td>
                                      <td><?php print $fn;?></td>
                                      <td><?php print $ln;?></td>
                                      <td><?php print $em;?></td>
                                      <td><?php print $cn;?></td>  
                                      <td><?php print $pd;?></td>
                                      <td>

                                         <a href="update-profile.php?uid=<?php print $id;?>"> 
                                         <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                         <a href="manage-users.php?uid=<?php print $id;?>"> 
                                         <button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');"><i class="fa fa-trash-o "></i></button></a>
                                      </td>
                                  </tr>
                                  <?php $cnt=$cnt+1; }?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
		</section>
      </section>
      <!-- Manage users sector -->
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
