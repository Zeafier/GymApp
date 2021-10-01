<?php 
include "admin/functions/XSS.php";

if (isset($_POST['submit'])){
    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $message = clean($_POST['message']);
    if(empty($name) || empty($email) || empty($message)){
        echo "<script>alert('One of the field if empty.')";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "<script>alert('Incorrect address email.')";
    }else{
        $to_email = 'W4A@wellness.co.uk';
        $subject = 'Users enquery';
        $message = $message;
        $headers = 'From: '.$name.'';
        mail($to_email,$subject,$message,$headers);

        echo "<script>alert('Email query has been sended. We will get in touch with you as soon as possible!')";
    }
}


?>