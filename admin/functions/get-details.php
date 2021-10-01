<?php

$_SESSION['msg'] = "";
/* Check if user id is numeric */
if(is_numeric($_GET['uid'])){
    $_id_ = clean($_GET['uid']);
    /* Get choosen type */
    if(isset($_POST['type'])){
        $type = clean($_POST['type']);
        /* Look for user's class informtions */
        if($type == "class"){
            $sql = $con -> prepare("Select _cu_ID_,_Class_name_,_date_ FROM _user_class_,_class_ WHERE _user_ID_ = ? AND _is_confirmed_ = 1 AND _date_ >= CURRENT_DATE AND _user_class_._class_ID_ = _class_._cID_ GROUP BY _date_");
            $sql -> bind_param("i", $_id_);
            $sql -> execute();
            $sql -> store_result();
            if($sql->num_rows > 0){
                $sql -> bind_result($cu_id, $class, $date);
            ?>
            <table class="table table-striped table-advance table-hover">
              <h4 id="type2" name="type2" value="class"><i class="fa fa-angle-right"></i> Class details </h4>
              <hr>
              <thead>
              <tr>
                  <th>Sno.</th>
                  <th class="hidden-phone">Class name</th>
                  <th> Date</th>
                  <th> Tick to take action</th>
              </tr>
              </thead>
              <tbody>
                  <?php 
                $cnt=1;
                /* Fetch all results */
                  while($sql->fetch())
                  {?>
                  <tr>
                      <td><?php print $cnt;?></td>
                      <td><?php print $class;?></td>
                        <td><input type='date' name = '<?php print $date;?>' value="<?php print $date;?>"></td>
                        <td><input class="toggle__input" type="checkbox" style="margin-left:50px;" name="chid[]" value="<?php print $cu_id;?>"></td>
                  </tr>
                  <?php $cnt=$cnt+1; }?>
              </tbody>
                <div style="margin-left:70%;">
                  <input type="submit" name="Update01" value="Update" style="margin-right:100px;" onClick="return confirm('Do you really want to update selected items');" class="btn btn-theme04">
                  <input type="submit" name="Remove01" value="Remove" onClick="return confirm('Do you really want to delete selected items');" class="btn btn-theme04">
                </div>
          </table>
            <?php
            }else{
                $_SESSION['msg'] = "Empty records";
            }
            /* Look for personal trainer informtions */
        }else if($type == "personal"){
            $sql = $con -> prepare("Select _btID_,_pFN_,_pLN_,_bDATE_,_Class_name_ FROM _book_trainer,_personal_trainer_,_class_ WHERE _uID_ = ? AND _is_confirm_ = 1 AND _bDATE_ >= CURRENT_DATE AND _book_trainer._tID_ = _personal_trainer_._pID_ AND _class_._cID_=_book_trainer._cID_ GROUP BY _bDATE_");
            $sql -> bind_param("i", $_id_);
            $sql -> execute();
            $sql -> store_result();
            if($sql->num_rows > 0){
                $sql -> bind_result($tID, $name, $surname, $date, $class);
            ?>
            <table class="table table-striped table-advance table-hover">
              <h4 name="type2" value="personal"><i class="fa fa-angle-right"></i> Personal trainer's details </h4>
              <hr>
              <thead>
              <tr>
                  <th>Sno.</th>
                  <th class="hidden-phone">Trainer name</th>
                  <th class="hidden-phone">Class</th>
                  <th> Date</th>
                  <th> Tick to take action</th>
              </tr>
              </thead>
              <tbody>
                  <?php 
                $cnt=1;
                /* Fetch all results */
                  while($sql->fetch())
                  {?>
                  <tr>
                      <td><?php print $cnt;?></td>
                      <td><?php print $name;?> <?php print $surname;?></td>
                      <td><?php print $class;?></td>
                        <td><input type='date' name = '<?php print $date;?>' value="<?php print $date;?>"></td>
                        <td><input class="toggle__input" type="checkbox" style="margin-left:50px;" name="chid[]" value="<?php print $tID;?>"></td>
                  </tr>
                  <?php $cnt=$cnt+1; }?>
              </tbody>
                <div style="margin-left:70%;">
                  <input type="submit" name="Update02" value="Update" style="margin-right:100px;" onClick="return confirm('Do you really want to update selected items');" class="btn btn-theme04">
                  <input type="submit" name="Remove02" value="Remove" onClick="return confirm('Do you really want to delete selected items');" class="btn btn-theme04">
                </div>
          </table>
            <?php
            }else{
                $_SESSION['msg'] = "Empty records";
            }
        }else{
            $_SESSION['msg'] = "Error";
        }
    }else{
        $_SESSION['msg'] = "Something went wrong";
    }
}else{
    $_SESSION['msg'] = "Something";
}
?>