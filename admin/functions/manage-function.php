<?php

//Search for customer
if(isset($_POST['Search'])){
    if(!empty($_POST["name_value"])){
        $res = clean($_POST['search-by']);
        $name = "name";
        $sur = "surname";
        $em = "email";
        //Search by name
        if($res==$name){
            $val=clean($_POST["name_value"]);
            $val = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$val);
            $cnt=1;
            $sql = $con -> prepare("Select _uID_, _fn_, _ln_, _em_ FROM _users_ WHERE _is_admin_ = 0 AND _fn_ LIKE CONCAT('%',?,'%')");
            $sql -> bind_param("s", $val);
            $sql -> execute();
            $sql -> bind_result($id, $fn, $ln, $em);
            if(!$sql->num_rows > 0){
                while ($sql->fetch())
                { ?>
                <tr>
                <td><?php print $cnt;?></td>
                  <td><?php print $fn;?></td>
                  <td><?php print $ln;?></td>
                  <td><?php print $em;?></td>
                  <td>
                     <a href="user-booking.php?uid=<?php print $id;?>"> 
                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                     <a href="make-booking.php?uid=<?php print $id;?>"> 
                     <button class="btn btn-danger btn-xs"><i class="fa fa-plus-circle"></i></button></a>
                  </td>
                </tr>
                <?php $cnt=$cnt+1; 
                }
                $sql -> close();
            }else{
                echo "<p><center><h2>Records not found</h2></center></p>";
            }  
            //Search by surname
        }else if($res==$sur){
            $val=clean($_POST["name_value"]);
            $val = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$val);
            $cnt=1;
            $sql = $con -> prepare("Select _uID_, _fn_, _ln_, _em_ FROM _users_ WHERE _is_admin_ = 0 AND _ln_ LIKE CONCAT('%',?,'%')");
            $sql -> bind_param("s", $val);
            $sql -> execute();
            $sql -> bind_result($id, $fn, $ln, $em);
            if(!$sql->num_rows > 0){
                while ($sql->fetch())
                { ?>
                <tr>
                <td><?php print $cnt;?></td>
                  <td><?php print $fn;?></td>
                  <td><?php print $ln;?></td>
                  <td><?php print $em;?></td>
                  <td>

                     <a href="user-booking.php?uid=<?php print $id;?>"> 
                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                     <a href="make-booking.php?uid=<?php print $id;?>"> 
                     <button class="btn btn-danger btn-xs"><i class="fa fa-plus-circle"></i></button></a>
                  </td>
                </tr>
                <?php $cnt=$cnt+1; 
                }
                $sql -> close();
            }else{
                echo "<p><center><h2>Records not found</h2></center></p>";
            }
            //Search by email
        }else if($res==$em){
            $val=clean($_POST["name_value"]);
            $val = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$val);
            $cnt=1;
            $sql = $con -> prepare("Select _uID_, _fn_, _ln_, _em_ FROM _users_ WHERE _is_admin_ = 0 AND _em_ LIKE CONCAT('%',?,'%')");
            $sql -> bind_param("s", $val);
            $sql -> execute();
            $sql -> bind_result($id, $fn, $ln, $em);
            if(!$sql->num_rows > 0){
                while ($sql->fetch())
                {?>
                <tr>
                <td><?php print $cnt;?></td>
                  <td><?php print $fn;?></td>
                  <td><?php print $ln;?></td>
                  <td><?php print $em;?></td>
                  <td>

                     <a href="user-booking.php?uid=<?php print $id;?>"> 
                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                     <a href="make-booking.php?uid=<?php print $id;?>"> 
                     <button class="btn btn-danger btn-xs"><i class="fa fa-plus-circle"></i></button></a>
                  </td>
                </tr>
                <?php $cnt=$cnt+1; 
                }
                $sql -> close();
            }else{
                echo "<p><center><h2>Records not found</h2></center></p>";
            }
        }
    }else{
        echo "<script>alert('Fill empy space');</script>";
    }
}

?>