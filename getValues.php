<?php

$date;

/* Collect choosen information */
if(isset($_POST["check_class"])){
    $type1 = clean($_POST["type"]);
    $type2 = clean($_POST["booking"]);
    /* Check if comboboxes are empty */
    if($type1=="" || $type2==""){
        echo "<script>alert('Choose correct booking');</script>";
    }
    //Coding for listing current classes
    if($type1=="1" && $type2=="1"){
            $id = clean($_SESSION['id']);
            $stmnt = $con-> prepare("Select _cu_ID_,_Class_name_,_date_ FROM _user_class_,_class_ WHERE _user_ID_ = ? AND _is_confirmed_ = 1 AND _date_ >= CURRENT_DATE AND _user_class_._class_ID_ = _class_._cID_ GROUP BY _date_");
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $stmnt->store_result();
            print "<p>Manage current classes</p>";
                    print "<table id='newform'>
                        <tr>
                            <th>Class name</th>
                            <th>Date</th>
                            <th>Remove</th>
                            <th>Update</th>
                        </tr>";
            if($stmnt->num_rows > 0){
                $stmnt -> bind_result($cu_id, $class, $date);
                while($stmnt->fetch()){
                    print "<form name='DateBook' id='DateBook' method='POST'><tr>
                            <th>".$class."</th>
                            <th><input type='date' name = 'mcids' value=".$date."></th>
                            <th><button name='rbID' class='button-delete' onclick='return deleletconfig()' type='submit' value='".$cu_id."'></th>
                            <th><button name='bID' class='button-update' onclick='return updateBook()' type='submit' value='".$cu_id."'></th>
                        </tr></form>";
                }
                print "</table>";
            }else{
                print "</table>"; 
                print "<p>Records are empty. Go to <a href='Book.php'>bookings</a> to book new class</p>";
            }
        $stmnt->close();
            
    }
    //Coding for listing current trainers
    if($type1=="1" &&  $type2=="2"){
        $id = clean($_SESSION['id']);
        $stmnt = $con-> prepare("Select _btID_,_pFN_,_pLN_,_bDATE_,_Class_name_ FROM _book_trainer,_personal_trainer_,_class_ WHERE _uID_ = ? AND _is_confirm_ = 1 AND _bDATE_ >= CURRENT_DATE AND _book_trainer._tID_ = _personal_trainer_._pID_ AND _class_._cID_=_book_trainer._cID_ GROUP BY _bDATE_");
        $stmnt -> bind_param("s", $id);
        $stmnt -> execute();
        $stmnt->store_result();
        print "<p>Manage current trainers</p>";
                print "<table>
                    <tr>
                        <th>Trainer name</th>
                        <th>Class name</th>
                        <th>Date</th>
                        <th>Remove</th>
                        <th>Update</th>
                    </tr>";
        if($stmnt->num_rows > 0){
            $stmnt -> bind_result($tID, $name, $surname, $date, $class);
            while($stmnt->fetch()){
                print "<form name='DateBook' id='DateBook' method='POST'><tr>
                        <th>".$name." ".$surname."</th>
                        <th>".$class."</th>
                        <th><input type='date' name = 'mcids' value=".$date."></th>
                        <th><button name='rtID' class='button-delete' onclick='return deleletconfig()' type='submit' value='".$tID."'></th>
                        <th><button name='tbID' class='button-update' type='submit' onclick='return updateBook()' value='".$tID."'></th>
                    </tr></form>";
            }
            print "</table>";
        }else{
            print "</table>";
            print "<p>Records are empty. Go to <a href='Book.php'>bookings</a> to book your trainer</p>";
        }
    }
    //Coding for listing past classes
    if($type1=="2" &&  $type2=="1"){
        $id = clean($_SESSION['id']);
            $stmnt = $con-> prepare("Select _cu_ID_,_Class_name_,_date_ FROM _user_class_,_class_ WHERE _user_ID_ = ? AND _is_confirmed_ = 1 AND _date_ < CURRENT_DATE AND _user_class_._class_ID_ = _class_._cID_");
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $stmnt->store_result();
            print "<p>Past classes</p>";
                    print "<table>
                        <tr>
                            <th>Class name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>";
            if($stmnt->num_rows > 0){
                $stmnt -> bind_result($cu_id, $class, $date);
                while($stmnt->fetch()){
                    print "<tr>
                            <th>".$class."</th>
                            <th>".$date."</th>
                            <th>No available</th>
                        </tr>";
                }
                print "</table>";
            }else{
                print "</table>";
                print "<p>No past activities</p>";
            }
    }
    //Coding for listing past trainers
    if($type1=="2" &&  $type2=="2"){
        $id = clean($_SESSION['id']);
            $stmnt = $con-> prepare("Select _btID_,_pFN_,_pLN_,_bDATE_,_Class_name_ FROM _book_trainer,_personal_trainer_,_class_ WHERE _uID_ = ? AND _is_confirm_ = 1 AND _bDATE_ < CURRENT_DATE AND _book_trainer._tID_ = _personal_trainer_._pID_ AND _class_._cID_=_book_trainer._cID_");
            $stmnt -> bind_param("s", $id);
            $stmnt -> execute();
            $stmnt->store_result();
            print "<p>Past activities with trainers</p>";
                    print "<table>
                        <tr>
                            <th>Trainer name</th>
                            <th>Class name</th>
                            <th>Date</th>
                            <th>Choose action</th>
                        </tr>";
            if($stmnt->num_rows > 0){
                $stmnt -> bind_result($tID, $name, $surname, $date, $class);
                while($stmnt->fetch()){
                    print "<tr>
                            <th>".$name." ".$surname."</th>
                            <th>".$class."</th>
                            <th>".$date."</th>
                            <th>Not available</th>
                        </tr>";
                }
                print "</table>";
            }else{
                print "</table>";
                print "<p>Records are empty.</p>";
            }
    }
}


$fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//Messeges boxes displayed after changing or removing class/personal trainer
if (strpos($fullUrl, "manage=match") == true){
    echo "<script>alert('Your date is matching previous date'); window.location.href = 'manage.php';</script>";
}
if (strpos($fullUrl, "manage=incorrect") == true){
    echo "<script>alert('Incorrect date'); window.location.href = 'manage.php';</script>";
}
if (strpos($fullUrl, "manage=busy") == true){
    echo "<script>alert('Choosen date is not available. Try choose another date'); window.location.href = 'manage.php';</script>";
}
if (strpos($fullUrl, "manage=success") == true){
    echo "<script>alert('Your date has been successfully updated'); window.location.href = 'manage.php';</script>";
}
if (strpos($fullUrl, "manage=error") == true){
    echo "<script>alert('Something went wrong. Try again'); window.location.href = 'manage.php';</script>";
}
?>
    <!-- Proceed choosen action -->
    <script>
        //Function for updating items
        function updateBook(){
            var del=confirm("Are you sure you want to change this records?");
            if (del==true){
                <?php
                //Function to update user's activity date
                    if(isset($_POST['bID'])){
                        $cuid=clean($_POST['bID']);
                        $stmnt = $con->prepare("Select _date_ FROM _user_class_ where _cu_ID_ = ?");
                        $stmnt -> bind_param("i", $cuid);
                        $stmnt -> execute();
                        $stmnt -> bind_result($date);
                        if ($stmnt -> fetch()){
                            $stmnt -> close();
                            if(isset($_POST['mcids'])){
                                $cdate = clean($_POST['mcids']);
                                $a=date('Y-m-d');
                                $newDate = date("Y-m-d", strtotime($cdate));
                                
                                $stmnt = $con->prepare("Select _class_id_ FROM _user_class_,_class_ WHERE _cu_ID_= ? AND _user_class_._class_id_=_class_._cID_");
                                $stmnt -> bind_param("i", $cuid);
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
                                            header("Location: ../Assignment/manage.php?manage=match");
                                        }else if($cdate < $a){
                                            header("Location: ../Assignment/manage.php?manage=incorrect");
                                        }else if($counter > 5){
                                            header("Location: ../Assignment/manage.php?manage=busy");
                                        }else{
                                            $query = $con->prepare("Update _user_class_ SET _date_ = ? WHERE _cu_ID_ = ?");
                                            $query->bind_param("si",$newDate, $cuid);
                                            if($query->execute()){
                                                $query->close();
                                                header("Location: ../Assignment/manage.php?manage=success");
                                            }else{
                                                $query->close();
                                                header("Location: ../Assignment/manage.php?manage=error");
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            header("Location: ../Assignment/manage.php?manage=error");
                        }
                    }

                //Function to update user's trainer date
                if(isset($_POST['tbID'])){
                        $cuid=clean($_POST['tbID']);
                        $stmnt = $con->prepare("Select _bDATE_ FROM _book_trainer where _btID_ = ?");
                        $stmnt -> bind_param("i", $cuid);
                        $stmnt -> execute();
                        $stmnt -> bind_result($date);
                        if ($stmnt -> fetch()){
                            $stmnt -> close();
                            if(isset($_POST['mcids'])){
                                $cdate = clean($_POST['mcids']);
                                $a=date('Y-m-d');
                                $newDate = date("Y-m-d", strtotime($cdate));
                                
                                $stmnt = $con->prepare("Select _tID_ FROM _book_trainer WHERE _btID_= ?");
                                $stmnt -> bind_param("i", $cuid);
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
                                            header("Location: ../Assignment/manage.php?manage=match");
                                        }else if($cdate < $a){
                                            header("Location: ../Assignment/manage.php?manage=incorrect");
                                        }else if($counter > 1){
                                            header("Location: ../Assignment/manage.php?manage=busy");
                                        }else{
                                            $query = $con->prepare("Update _book_trainer SET _bDATE_ = ? WHERE _btID_ = ?");
                                            $query->bind_param("si",$newDate, $cuid);
                                            if($query->execute()){
                                                header("Location: ../Assignment/manage.php?manage=success");
                                                $query->close();
                                            }else{
                                                header("Location: ../Assignment/manage.php?manage=error");
                                                $query->close();
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            header("Location: ../Assignment/manage.php?manage=error");
                        }
                    }
                ?>
            }
            return del;
        }
    </script>