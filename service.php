<?php
session_start();
require_once('checker/dbconnection.php');
include "admin/functions/XSS.php";

$cityid;
$name_error_msg = "";
$lname_error_msg = "";
$property_error_msg = "";
$postcode_error_msg = "";
$password_error_msg = "";
$phone_error_msg = "";
$email_error_msg = "";
$name = "";

//Code for Registration 
if(isset($_POST['signup']))
{
    $city_name=clean($_POST['city']);
    $fname=clean($_POST['fname']);
    $lname=clean($_POST['lname']);
    $email=clean($_POST['email']);
    $password=clean($_POST['password']);
    $contact=clean($_POST['contact']);
    $postcode=clean($_POST['pc']);
    $nh=clean($_POST['nhouse']);
    $sname=clean($_POST['sname']);
    $r_p=clean($_POST['r_password']);
    $vnull = null;
    $ia = 0;

    $hpw = password_hash($password, PASSWORD_BCRYPT);
    $a=date('Y-m-d'); 

    $stmnt = $con->prepare("Select _em_ From _users_ Where _em_ = ?");
    $stmnt->bind_param("s",$email);
    $stmnt->execute();    

    //check if fields are ampty
    if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['sname']) || empty($_POST['pc']) || empty($_POST['password']) || empty($_POST['r_password']) || empty($_POST['contact']) || empty($_POST['email']) || empty($_POST['nhouse'])){
        $stmnt->close();
        $name_error_msg = "Name is a required field";
        $lname_error_msg = "Surname is a required field";
        $property_error_msg = "Street is a required field";
        $postcode_error_msg = "Postcode is a required field";
        $password_error_msg = "Password is a required field";
        $phone_error_msg = "Phone number is a required field";
        $email_error_msg = "Email is a required field";
    //Validate email
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $stmnt->close();
        $email_error_msg = "Email is invalid.";
    //Validate number phone
    }else if(!filter_var($contact, FILTER_VALIDATE_INT)){
        $stmnt->close();
        $phone_error_msg = "Please enter only a number with no spaces or special characters";
    //Validate if passwords are equal
    }else if($password != $r_p){
        $stmnt->close();
        $password_error_msg = "Password must match";
    //Check if user exists
    }else if($stmnt->fetch()!=0){
        echo "<script>alert('Your account already exists');</script>";
        $stmnt -> close();
    //check if contain one big and one small letter and one number
    }else if(!preg_match( '~[A-Z]~', $password) || !preg_match( '~[a-z]~', $password) || !preg_match( '~\d~', $password)){
        $stmnt->close();
        $password_error_msg = "Password must contain at least one small letter, one big letter and one number";
    //check if password is correct
    }else if(strlen($password) < 6 || strlen($password) > 15){
        $stmnt->close();
        $password_error_msg = "Password must be between 6-15 characters";
    }else{
        //Proceed to create account
        $msg = "Select _Postcode_ FROM _address_ WHERE _Postcode_ = ?;";
        $stmnt1 = $con->prepare($msg);
        $stmnt1 -> bind_param("s", $postcode);
        $stmnt1 -> execute();
        if($stmnt1->fetch()!=0){
            $stmnt1 -> close();
            $stmnt2 = $con->prepare("INSERT INTO _users_ (_uID_, _pw_, _posting_date_, _postcode_, _h_number_, _ln_, _fn_, _em_, _contactno_, _is_admin_) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmnt2 -> bind_param("isssssssis", $vnull, $hpw, $a, $postcode, $nh, $lname, $fname, $email, $contact, $ia);
            if($stmnt2 -> execute()){
                echo "<script>alert('Your account has been created.');</script>";
                $stmnt2 -> close();
            }else{
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }else{
            $stmnt3 = $con->prepare("Select _cID_ FROM _city_ WHERE _c_name_ = ?;");
            $stmnt3 -> bind_param("s", $city_name);
            $stmnt3 -> execute();
            $stmnt3 -> bind_result($cityid);
            if($stmnt3->fetch()!=0){
                $stmnt3 -> close();
                $stmnt4 = $con -> prepare("INSERT INTO _address_ (_cID_, _Postcode_, _Street_) VALUES (?, ?, ?)");
                $stmnt4 -> bind_param("sss", $cityid, $postcode, $sname);
                if($stmnt4 -> execute()){
                    $stmnt4 -> close();
                    $stmnt5 = $con->prepare("INSERT INTO _users_ (_uID_, _pw_, _posting_date_, _postcode_, _h_number_, _ln_, _fn_, _em_, _contactno_, _is_admin_) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmnt5 -> bind_param("isssssssis", $vnull, $hpw, $a, $postcode, $nh, $lname, $fname, $email, $contact, $ia);
                    if($stmnt5 -> execute()){
                        echo "<script>alert('Your account has been created.');</script>";
                        $stmnt5 -> close();
                    }else{
                        echo "<script>alert('Something went wrong. Please try again.');</script>";
                    }
                }else{
                    echo "<script>alert('City not selected.');</script>";
                }   
            }else{
                echo "<script>alert('City is not selected. Please try again.');</script>";
            }
        }
    }
}

// Code for login system
else if(isset($_POST['login']))
{
    $password=clean($_POST['password']);
    $useremail=clean($_POST['uemail']);
    $userid;
    $pword;
    if(empty($password) || empty($useremail)){
        echo "<script>alert('Email and Passwords are required');</script>";
    }else{
        $stmnt = $con->prepare("Select _uID_, _pw_, _is_admin_, _fn_ From _users_ Where _em_ = ?");
        $stmnt->bind_param("s",$useremail);
        $stmnt->execute();
        $stmnt->bind_result($userid, $pword, $ia, $name);
        if($stmnt->fetch()!=0){
            if(password_verify($password, $pword) && $ia == 0)
            {
                $extra="welcome.php";
                $_SESSION['login']=clean($useremail);
                $_SESSION['id']=clean($userid);
                $_SESSION['name']=clean($name);
                $host=$_SERVER['HTTP_HOST'];
                $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                header("location:http://$host$uri/$extra");
                exit();
            }else if(password_verify($password, $pword) && $ia == 1){
                $extra="admin/manage-users.php";
                $_SESSION['login']=clean($useremail);
                $_SESSION['id']=clean($userid);
                echo "<script>window.location.href='".$extra."'</script>";
                exit();  
            }
            else{
                echo "<script>alert('Invalid username or password');</script>";
                $extra="service.php";
                $host  = $_SERVER['HTTP_HOST'];
                $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                $stmnt->close();
            }   
        }else{
            echo "<script>alert('Invalid username or password');</script>";
            $stmnt -> close();
        }
    }
}

//Code for Forgot Password

else if(isset($_POST['send']))
{
    $em = clean($_POST['femail']);
    $sql = $con -> prepare("Select _em_,_pw_ FROM _users_ WHERE _em_ = ? ");
    $sql -> bind_param("s", $em);
    $sql -> execute();
    $sql -> bind_result($email, $PW);
    if($sql->fetch())
    {
        $subject = "Information about your password";
        $message = "Your password is ".$PW;
        mail($email, $subject, $message, "From: .$email.");
        echo  "<script>alert('Your Password has been sent Successfully');</script>";
    }
    else
    {
        echo "<script>alert('Email not register with us');</script>";
    }
    $sql -> close();
}


?>
<!DOCTYPE html>
<html>
    
    <!-- Script for restrictions -->
    <script>
		function RestrictSpace() {
			if (event.keyCode == 32) {
				event.returnValue = false;
				return false;
			}
		}
	
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
        }
        
        function isLetter(){
             var ch = String.fromCharCode(event.keyCode);
             var filter = /[a-zA-Z ]/   ;
             if(!filter.test(ch)){
                  event.returnValue = false;
             }
        }
        
        function isPostcode(){
            var ch = String.fromCharCode(event.keyCode);
             var filter = /[a-zA-Z0-9]/;
            if(!filter.test(ch)){
                  event.returnValue = false;
             }
        }

    </script>
    <!-- Script for restrictions -->
    
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Roehampton">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login System</title>
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Elegent Tab Forms,Login Forms,Sign up Forms,Registration Forms,News latter Forms,Elements"./>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#horizontalTab').easyResponsiveTabs({
                type: 'default',       
                width: 'auto', 
                fit: true 
            });
        });
       </script>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600,700,200italic,300italic,400italic,600italic|Lora:400,700,400italic,700italic|Raleway:400,500,300,600,700,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700' rel='stylesheet' type='text/css'>
    <!-- Font Awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <!--Style sheet-->
    <link rel="stylesheet" href="../Assignment/css/fontawesome-free-5.9.0-web/css/all.css"> <!--load all styles -->
</head>
<body>
    <header>
        <!-- Navigation -->
        <nav>
            <div class="wrapper-menu">
                <a href="index.html">
                    <div class="logo"></div>
                </a>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="gym.html">Why gym?</a></li>
                    <li><a href="classes.html">Classes</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
                <div class="bt-login">
                    <a href="service.php"><button type="submit">Login</button></a>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Main body -->
<div class="main">
    <!-- Tab selection -->
		<h1><center>Registration and Login System</center></h1>
	 <div class="sap_tabs">	
			<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
			  <ul class="resp-tabs-list">
                  <li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><div class="top-img"><img src="images/top-lock.png" alt=""/></div><span>Login</span></li>
			  	  <li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><div class="top-img"><img src="images/top-note.png" alt=""/></div><span>Register</span></li>
				  <li class="resp-tab-item lost" aria-controls="tab_item-2" role="tab"><div class="top-img"><img src="images/top-key.png" alt=""/></div><span>Forgot Password</span></li>
				  <div class="clear"></div>
			  </ul>		
			  	<!-- Tab selection -->
			<div class="resp-tabs-container">
                <!-- Login -->
                        <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
                        <div class="facts">
                             <div class="login" id="login">
                                <div class="buttons">								
                                </div>
                                <form name="login" action="" method="post">
                                    <input type="text" class="text" name="uemail" value="" placeholder="Enter your registered email"  ><a href="#" class=" icon email"></a>
                                    <input type="password" value="" name="password" placeholder="Enter valid password"><a href="#" class=" icon lock"></a>
                                    <div class="p-container">
                                        <div class="submit two">
                                        <input type="submit" name="login" value="LOG IN" >
                                        </div>
                                        <div class="clear"> </div>
                                    </div>
                                </form>
                            </div>
                        </div> 
                    </div> 
                <!-- Login -->
                
					<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
					<div class="facts">
                        <!-- Register -->
						<div class="register">
							<form name="registration" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
								<p>First Name </p>
								<input type="text" class="text" value=""  name="fname" maxlength="45" required onkeypress="return isLetter(event)">
                                <span style="color: white">*<?php echo $name_error_msg;?></span>
								<p>Last Name </p>
								<input type="text" class="text" value="" name="lname" maxlength="45" required onkeypress="return isLetter(event)">
                                <span style="color: white">*<?php echo $lname_error_msg;?></span>
                                <p>Street name </p>
                                <input type="text" class="text" value="" name="sname" maxlength="90" required onkeypress="return isLetter(event)">
                                <span style="color: white">*<?php echo $property_error_msg;?></span>
                                <p>House number </p>
                                <input type="text" class="text" value="" name="nhouse" maxlength="5" required >
                                <p>City: </p>
                                    <?php
                                        $sql = $con->prepare("SELECT _c_name_ FROM _city_ GROUP BY _c_name_");
                                        $sql -> execute();
                                        echo '<select name="city">';
                                        echo '<option value="">Select*</option>';
                                        $sql->bind_result($cityname);
                                        while ($sql->fetch()) {
                                            echo '<option value="'.$cityname.'">'.$cityname.'</option>';
                                        }
                                        echo '</select>';
                                        $sql->close();
                                        ?>
                                <p>Postcode </p>
                                <input type="text" class="text" value="" name="pc" required maxlength="7" onkeypress="return isPostcode(event)">
                                <span style="color: white">*<?php echo $postcode_error_msg;?></span>
								<p>Email Address </p>
								<input type="text" class="text" value="" name="email" oninput="">
                                <span style="color: white">*<?php echo $email_error_msg;?></span>
								<p>Password </p>
								<input type="password" value="" name="password" maxlength="20" required onkeypress="return RestrictSpace()">
                                <span style="color: white">*<?php echo $password_error_msg;?></span>
                                <p>Reaped Password </p>
								<input type="password" value="" name="r_password" maxlength="20" required onkeypress="return RestrictSpace()">
                                <span style="color: white">*<?php echo $password_error_msg;?></span>
								<p>Contact No. </p>
								<input type="number" value="" name="contact" required required maxlength="11" onkeypress="return isNumberKey(event)">
                                <span style="color: white">*<?php echo $phone_error_msg;?></span>
								<div class="sign-up">
									<input type="reset" value="Reset">
									<input type="submit" name="signup"  value="Sign Up"/>
									<div class="clear"> </div>
								</div>
							</form>

						</div>
                        <!-- Register -->
					</div>
				</div>
                <!-- Forget passwords -->
				 <div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
					 	<div class="facts">
							 <div class="login">
							<div class="buttons">	
							</div>
							<form name="login" action="" method="post">
								<input type="text" class="text" name="femail" value="" placeholder="Enter your registered email" required  ><a href="#" class=" icon email"></a>
                                    <div class="submit three">
                                        <input type="submit" name="send" onClick="myFunction()" value="Send Email" >
                                    </div>
                                </form>
                                </div>
                        </div>           	      
				        </div>	
                <!-- Forget passwords -->
				     </div>	
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

</body>
</html>