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
                if ($_POST['type'][0]=="Donor"){
                    $value1="Donor";
                }elseif($_POST['type'][0]=="Volunteer"){
                    $value1="Volunteer";
                }
            }elseif ($counts1==2){
                $value1="Donor & Volunteer";
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
                header('location:/event?event_id='.$event_id);
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
            if ($_POST['type'][0]=="Donor"){
                $value1="Donor";
            }elseif($_POST['type'][0]=="Volunteer"){
                $value1="Volunteer";
            }
        }elseif ($counts1==2){
            $value1="Donor & Volunteer";
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
            header('location:/event?event_id='.$event_id);


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
            header('location:/event?event_id='.$event_id);
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
<div><label class="head_label">Like to be </label><br>

    <input type="checkbox" name="type[]"  value="Donor" <?php if ($submit_type==="option"){if($type === 'Donor' OR $type === 'Donor & Volunteer' ) echo "checked='checked'"; }?>>Donor
    <input type="checkbox" name="type[]" value="Volunteer" <?php if ($submit_type==="option"){if($type === 'Volunteer' OR $type === 'Donor & Volunteer' ) echo "checked='checked'"; }?>>Volunteer<br/><br/>
</div>


<div >
    <label class="head_label"> District/Districts where you want to serve</label><br>
    <select name="district[]"multiple="multiple" >
            <option value='Ampara'>Ampara</option>
            <option value='Anurashapura'>Anurashapura</option>
            <option value='Badulla'>Badulla</option>
            <option value='Batticaloa'>Batticaloa</option>
            <option value='Colombo'>Colombo</option>
            <option value='Galle'>Galle</option>
            <option value='Gampha'>Gampha</option>
            <option value='Hambatota'>Hambantota</option>
            <option value='Jaffna'>Jaffna</option>
            <option value='Kaltura'>Kaltura</option>
            <option value='Kandy'>Kandy</option>
            <option value='Kegalle'>Kegalle</option>
            <option value='Kilinochchi'>Kilinochchi</option>
            <option value='Kurunegala'>Kurunegala</option>
            <option value='Mannar'>Mannar</option>
            <option value='Matale'>Matale</option>
            <option value='Mathara'>Mathara</option>
            <option value='Moneragala'>Moneragala</option>
            <option value='Mullaitivu'>Mullaitivu</option>
            <option value='Nuwara-Eliya'>Nuwara-Eliya</option>
            <option value='Polonnaruwa'>Polonnaruwa</option>
            <option value='Puttalam'>Puttalam</option>
            <option value='Ratnapura'>Ratnapura</option>
            <option value='Tricomalee'>Tricomalee</option>
            <option value='Vavuniya'>Vavuniya</option>
        </select><br><br>
</div>

<div><label class="head_label">Abilities </label><br>
<table>
        <tr>
            <td class=des_area>
                <div id=money_des_con style="display:block">
                    <textarea cols="15" rows="1"  class="input_box" name="money_description" id="money_des">Money</textarea>

                </div>
            </td>
            <td class=des_area>
                <div id=money_des_con style="display:block">
                    <textarea cols="15" rows="1"  class="input_box" name="money_description" id="money_des"></textarea>
                </div>
            </td>
            <td class=des_area>
                Rs
            </td>
        </tr>
        <input name="update_button" type="submit"  value="Add other" onclick="OnCreateCheckbox()">
        
    </table>
</div>

<div>
    <input name="update_button" type="submit"  value="Submit"  class="login_button">
    <button id=close_request_popup class=submit_button>Cancel</button>

</div>

</form>