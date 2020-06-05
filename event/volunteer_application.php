<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    if($_SERVER['REQUEST_METHOD']=='GET'){
        $event_id = $_GET['event_id'];
        $submit_type = $_GET['method'];
    }elseif($_SERVER['REQUEST_METHOD']=='POST'){
        $event_id = $_POST['event_id'];
        $submit_type = $_POST['method'];
    }
     


    //submit type = apply................................
    if ($submit_type==="apply"){

        $nic=$_SESSION['user_nic'];
        $value1="not_selected";
        $value2="not_selected";

        $counts1=0;
        $counts2=0;

        if (isset($_POST['update_button'])){
            $event_id = $_POST['event_id'];

            if( ! empty( $_POST['type'] )){
            $counts1 = count($_POST['type']);
            }
            if ($counts1==1){
                if ($_POST['type'][0]=="from_home"){
                    $value1="from_home";
                }elseif($_POST['type'][0]=="on_the_spot"){
                    $value1="on_the_spot";
                }
            }elseif ($counts1==2){
                $value1="both";
            }

            if( ! empty( $_POST['moneygoods'] )){
                $counts2 = count($_POST['moneygoods']);
            }
            if ($counts2==1){
                if ($_POST['moneygoods'][0]=="money"){
                    $value2="money";
                }elseif($_POST['moneygoods'][0]=="goods"){
                    $value2="goods";
                }
            }elseif ($counts2==2){
                $value2="both";
            }

            $districts="not_selected";
            if( ! empty( $_POST['district'] )){
                $values = $_POST['district'];
                $districts = implode(",", $values);
            }

            $t1=0;
            $t2="null";
            if( ! empty( $_POST['t1'] )){
                $t1=$_POST['t1'];
            }
            $t2=$_POST['t2'];

            $now="yes";
            $value="";
            $query="SELECT * FROM `event_".$event_id."_volunteers` where NIC_num='$nic'"; 
            $result=($con->query($query))->fetch_assoc();
            $value=$result['NIC_num'];
            echo $value;
            if ($value==="$nic"){
                $query="UPDATE `event_".$event_id."_volunteers` SET service_district='$districts',type='$value1',money_or_goods='$value2',amount='$t1',things='$t2', now='$now' where NIC_num='$nic'";
                $query_run= mysqli_query($con,$query);
            }else{
                $query= "INSERT INTO `event_".$event_id."_volunteers` (`NIC_num`,`service_district`, `type`, `money_or_goods`, `amount`, `things`) VALUES ('$nic','$districts', '$value1', '$value2', '$t1', '$t2')";
                $query_run= mysqli_query($con,$query);
            }
            // code to update status---------------------------
            $event_id=$_POST['event_id'];
            $user_nic=$_SESSION['user_nic'];

            $sql="SELECT user_".$user_nic." from disaster_events where event_id='$event_id'";
            $result=($con->query($sql))->fetch_assoc();
        

            echo "<br><br>" .$user_nic;
            $status=explode(" ",$result['user_'.$user_nic]);
            print_r($status);

            $status[2]="applied";
            $my=join(" ",$status);
        
            $query1="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$my."' WHERE `disaster_events`.`event_id` = $event_id";
            $query_run1= mysqli_query($con,$query1);

            if($query_run AND $query_run1){
                echo '<script type="text/javascript"> alert ("Data Uploaded") </script>';
                header('location:'.$_SERVER['DOCUMENT_ROOT'].'/event?event_id='.$event_id);
            }
            else{
                echo '<script type="text/javascript"> alert ("Data not Uploaded") </script>';
            }
        }
    }

    //submit type=option..........................
    elseif ($submit_type==="option"){

        $nic=$_SESSION['user_nic'];
        $value1="not_selected";
        $value2="not_selected";

        $counts1=0;
        $counts2=0;

        if (isset($_POST['update_button'])){
            $event_id = $_POST['event_id'];

            if( ! empty( $_POST['type'] )){
        $counts1 = count($_POST['type']);
        }
        if ($counts1==1){
            if ($_POST['type'][0]=="from_home"){
                $value1="from_home";
            }elseif($_POST['type'][0]=="on_the_spot"){
                $value1="on_the_spot";
            }
        }elseif ($counts1==2){
            $value1="both";
        }

        if( ! empty( $_POST['moneygoods'] )){
            $counts2 = count($_POST['moneygoods']);
        }
        if ($counts2==1){
            if ($_POST['moneygoods'][0]=="money"){
                $value2="money";
            }elseif($_POST['moneygoods'][0]=="goods"){
                $value2="goods";
            }
        }elseif ($counts2==2){
            $value2="both";
        }

        $districts="not_selected";
        if( ! empty( $_POST['district'] )){
            $values = $_POST['district'];
            $districts = implode(",", $values);
        }

        $t1=0;
        $t2="null";
        if( ! empty( $_POST['t1'] )){
            $t1=$_POST['t1'];
        }
        $t2=$_POST['t2'];

        $query="UPDATE `event_".$event_id."_volunteers` SET service_district='$districts',type='$value1',money_or_goods='$value2',amount='$t1',things='$t2' where NIC_num='$nic'";
        
        
        $query_run= mysqli_query($con,$query);

        if($query_run){
            echo '<script type="text/javascript"> alert ("Data changed") </script>';
            header('location:'.$_SERVER['DOCUMENT_ROOT'].'/event?event_id='.$event_id);


        }
        else{
            echo '<script type="text/javascript"> alert ("Data not changed") </script>';
        }
    }

//submit type= cancel.........................
}elseif($submit_type==="cancel"){

        $nic=$_SESSION['user_nic'];
    
        $user_nic=$_SESSION['user_nic'];

        $sql="SELECT user_".$user_nic." from disaster_events where event_id='$event_id'";
        $result=($con->query($sql))->fetch_assoc();
        $status=explode(" ",$result["user_".$user_nic]);
        $status[2]="not_applied";
        $my=join(" ",$status);

        $now="no";
        
        $query="UPDATE `disaster_events` SET `user_".$_SESSION['user_nic']."` = '".$my."' WHERE `disaster_events`.`event_id` = $event_id";
        $query1="UPDATE `event_".$event_id."_volunteers` SET now='$now' where NIC_num='$nic'";

        $query_run= mysqli_query($con,$query);
        $query_run1= mysqli_query($con,$query1);


        if($query_run AND $query_run1){
            echo '<script type="text/javascript"> alert ("Successfully leaved") </script>';
            header('location:'.$_SERVER['DOCUMENT_ROOT'].'/event?event_id='.$event_id);
        }
        else{
            echo '<script type="text/javascript"> alert ("Not leaved") </script>';
        }
    
}
?>

<form  class="form_box" action="volunteer_application.php" method="POST">
    <input type=hidden name=event_id value="<?php echo $_GET['event_id'] ?>">
    <input type=hidden name=method value='<?php echo $submit_type ?>'>

    <?php
    if ($submit_type==="option"){
        $nic=$_SESSION['user_nic'];

        $query="SELECT * FROM `event_".$event_id."_volunteers` where NIC_num='$nic'"; 
        $result=($con->query($query))->fetch_assoc();
        $service_district=explode(",",$result['service_district']);                    
        $type=$result['type'];
        $money_or_goods=$result['money_or_goods'];
        $amount=$result['amount'];
        $things=$result['things'];
    }

    ?>

    <label class="label"  style="font-weight:bolder;">Type </label><br>

    from home<input type="checkbox" name="type[]"  value="from_home" <?php if ($submit_type==="option"){if($type === 'from_home' OR $type === 'both' ) echo "checked='checked'"; }?>><br/>
    on the spot<input type="checkbox" name="type[]" value="on_the_spot" <?php if ($submit_type==="option"){if($type === 'on_the_spot' OR $type === 'both' ) echo "checked='checked'"; }?>><br/><br/>

    <label class="label"  style="font-weight:bolder;">District/Districts </label><br>
    AllDistricts  <input type="checkbox" name="district[]" value='AllDistricts' <?php if ($submit_type==="option"){if (in_array("AllDistricts", $service_district))  echo "checked='checked'";} ?>>
    Ampara  <input type="checkbox" name="district[]" value='Ampara' <?php if ($submit_type==="option"){if(in_array("Ampara", $service_district)) echo "checked='checked'"; }?>>
    Anurashapura  <input type="checkbox" name="district[]" value='Anurashapura'<?php if ($submit_type==="option"){if(in_array("Anurashapura", $service_district))  echo "checked='checked'"; }?>><br/>
    Badulla   <input type="checkbox" name="district[]" value='Badulla'<?php if ($submit_type==="option"){if(in_array("Ampara", $service_district)) echo "checked='checked'";} ?>>
    Batticaloa  <input type="checkbox" name="district[]" value='Batticaloa'<?php if ($submit_type==="option"){if(in_array("Batticaloa", $service_district)) echo "checked='checked'"; }?>>
    Colombo <input type="checkbox" name="district[]" value='Colombo'<?php if ($submit_type==="option"){ if(in_array("Colombo", $service_district))echo "checked='checked'";} ?>><br/>
    Galle  <input type="checkbox" name="district[]" value='Galle'<?php if ($submit_type==="option"){if(in_array("Galle", $service_district)) echo "checked='checked'"; }?>>
    Gampha <input type="checkbox" name="district[]" value='Gampha'<?php if ($submit_type==="option"){if(in_array("Gampha", $service_district)) echo "checked='checked'"; }?>>
    Hambantota  <input type="checkbox" name="district[]" value='Hambatota'<?php if ($submit_type==="option"){ if(in_array("Hambatota", $service_district)) echo "checked='checked'"; }?>><br/>
    Jaffna   <input type="checkbox" name="district[]" value='Jaffna'<?php if ($submit_type==="option"){ if(in_array("Jaffna", $service_district)) echo "checked='checked'";} ?>>
    Kaltura  <input type="checkbox" name="district[]" value='Kaltura'<?php if ($submit_type==="option"){if(in_array("Kaltura", $service_district)) echo "checked='checked'";} ?>>
    Kandy  <input type="checkbox" name="district[]" value='Kandy'<?php if ($submit_type==="option"){if(in_array("Kandy", $service_district)) echo "checked='checked'"; }?>><br/>
    Kegalle <input type="checkbox" name="district[]" value='Kegalle'<?php if ($submit_type==="option"){ if(in_array("Kegalle", $service_district)) echo "checked='checked'"; }?>>
    Kilinochchi  <input type="checkbox" name="district[]" value='Kilinochchi'<?php if ($submit_type==="option"){if(in_array("Kilinochchi", $service_district)) echo "checked='checked'";} ?>>
    Kurunegala <input type="checkbox" name="district[]"  value='Kurunegala'<?php if ($submit_type==="option"){ if(in_array("Kurunegala", $service_district)) echo "checked='checked'"; }?>><br/>
    Mannar  <input type="checkbox" name="district[]"  value='Mannar'<?php if ($submit_type==="option"){if(in_array("Mannar", $service_district)) echo "checked='checked'";} ?>>
    Matale <input type="checkbox" name="district[]"  value='Matale'<?php if ($submit_type==="option"){if(in_array("Matale", $service_district)) echo "checked='checked'";} ?>>
    Mathara  <input type="checkbox" name="district[]"  value='Mathara'<?php if ($submit_type==="option"){if(in_array("Mathara", $service_district)) echo "checked='checked'"; }?>><br/>
    Moneragala <input type="checkbox" name="district[]"  value='Moneragala'<?php if ($submit_type==="option"){if(in_array("Moneragala", $service_district)) echo "checked='checked'";} ?>>
    Mullaitivu  <input type="checkbox" name="district[]"  value='Mullaitivu'<?php if ($submit_type==="option"){if(in_array("Mullaitivu", $service_district)) echo "checked='checked'"; }?>>
    Nuwara-Eliya <input type="checkbox" name="district[]"  value='Nuwara-Eliya'<?php if ($submit_type==="option"){if(in_array("Nuwara-Eliya", $service_district)) echo "checked='checked'"; }?>><br/>
    Polonnaruwa    <input type="checkbox" name="district[]"  value='Polonnaruwa'<?php if ($submit_type==="option"){if(in_array("Polonnaruwa", $service_district)) echo "checked='checked'";} ?>>
    Puttalam  <input type="checkbox" name="district[]"  value='Puttalam'<?php if ($submit_type==="option"){if(in_array("Puttalam", $service_district)) echo "checked='checked'"; }?>>
    Ratnapura   <input type="checkbox" name="district[]"  value='Ratnapura'<?php if ($submit_type==="option"){if(in_array("Ratnapura", $service_district)) echo "checked='checked'"; }?>><br/>
    Tricomalee  <input type="checkbox" name="district[]"  value='Tricomalee'<?php if ($submit_type==="option"){if(in_array("Tricomalee", $service_district)) echo "checked='checked'";} ?>>
    Vavuniya   <input type="checkbox" name="district[]"  value='Vavuniya'<?php if ($submit_type==="option"){if(in_array("Vavuniya", $service_district)) echo "checked='checked'"; }?>><br/><br/>

    <label class="label"  style="font-weight:bolder;">Money or Goods </label><br>

    Money<input type="checkbox" name="moneygoods[]" value="money" <?php if ($submit_type==="option"){if($money_or_goods === 'money' OR $money_or_goods === 'both') echo "checked='checked'";} ?>  onclick="OnChangeCheckbox (this,'amount')"id ="money"/>
    
    <input type="textbox" id="amount" value="<?php if ($submit_type==="option"){echo $amount;}?>" style="display:block" name="t1"/><br/>

    Goods<input type="checkbox" name="moneygoods[]" value="goods" <?php if ($submit_type==="option"){if($money_or_goods === 'goods' OR$money_or_goods === 'both') echo "checked='checked'"; }?> onclick="OnChangeCheckbox (this,'things')" id="goods"/>
    <input type="textbox" id="things"  value="<?php if ($submit_type==="option"){ echo $things;}?>"  style="display:block" name="t2"/ >
    <br/>
    <br/>

    <input name="update_button" type="submit"  value="Submit"  class="login_button"><br>   

</form>