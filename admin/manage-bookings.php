<?php
session_start();
include 'dbconnection.php';
include 'checklogin.php';
include "functions/XSS.php";
check_login();

$_SESSION['msg'] = "";

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Manage Users' booking</title>
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
      <!-- Search for customers -->
      <section id="main-content">
            <section class="wrapper">
                <h3> Search for customer</h3>
                <div class="row">
 
                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php print $_SESSION['msg'];?><?php print $_SESSION['msg']=""; ?></p>
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                               <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Search by: </label>
                               <div style="margin-left:100px;">
                                    <select id="search-by" name="search-by">
                                        <option value="name">Name</option>
                                        <option value="surname">Surname</option>
                                        <option value="email">Email</option>
                                    </select>
                                    <input type="text" name="name_value" style="margin-left:100px;" maxlength="45" value="" >
                                    <input type="submit" name="Search" style="margin-left:100px;" value="Search" class="btn btn-theme04">
                               </div>
                          </form>
                      </div>
                    </div>
                </div>
            </section>
      </section>
      <!-- Search for customers -->
      <!-- Choose user and action for user's booking -->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i>Manage Bookings</h3>
				<div class="row">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <p align="center" style="color:#F00;"><?php print $_SESSION['msg'];?><?php print $_SESSION['msg']=""; ?></p>
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Selected user's action </h4>
	                  	  	  <hr>
                              <thead>
                                  <tr>
                                      <th>Sno.</th>
                                      <th class="hidden-phone">First Name</th>
                                      <th> Last Name</th>
                                      <th> Email</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                    include "functions/manage-function.php";
                                  ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
		</section>
      </section>
      <!-- Choose user and action for user's booking -->
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
