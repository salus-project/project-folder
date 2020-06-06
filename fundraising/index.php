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

            $money="Money";
            if( ! empty( $_POST['money'] )){
                $money = $_POST['money'];}
            $amount="0";
            if( ! empty( $_POST['amount'] )){
                $amount = $_POST['amount'];}
            $data1 = $money.":".$amount;

            $data2="";

            if( ! empty( $_POST['things'] )){

                $things = $_POST['things'];
                $quantity = $_POST['quantity'];

                $count_arr = count($_POST['things']);
                for ($x = 0; $x <$count_arr; $x++) {
                    $data2=$data2.",".$things[$x].":".$quantity[$x];
                }
            }
            $data=$data1.$data2;


            $districts="not_selected";
            if( ! empty( $_POST['district'] )){
                $values = $_POST['district'];
                $districts = implode(",", $values);
            }
            $data="Money:0";

            $now="yes";
            $value="";
            $query="SELECT * FROM `event_".$event_id."_volunteers` where NIC_num='$nic'";
            $result=($con->query($query))->fetch_assoc();
            $value=$result['NIC_num'];
            echo $value;
            if ($value==="$nic"){
                $query="UPDATE `event_".$event_id."_volunteers` SET service_district='$districts',type='$value1', now='$now', abilities='$data' where NIC_num='$nic'";
                $query_run= mysqli_query($con,$query);
            }else{
                $query= "INSERT INTO `event_".$event_id."_volunteers` (`NIC_num`,`service_district`, `type`,`abilities`) VALUES ('$nic','$districts', '$value1','$data')";
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

            $money="Money";
            if( ! empty( $_POST['money'] )){
                $money = $_POST['money'];}
            $amount="0";
            if( ! empty( $_POST['amount'] )){
                $amount = $_POST['amount'];}
            $data1 = $money.":".$amount;
            $data2="";
            if( ! empty( $_POST['things'] )){
                $things = $_POST['things'];
                $quantity = $_POST['quantity'];

                $count_arr = count($_POST['things']);
                for ($x = 0; $x <$count_arr; $x++) {
                    $data2=$data2.",".$things[$x].":".$quantity[$x];
                }
            }
            $data=$data1.$data2;

            $districts="not_selected";
            if( ! empty( $_POST['district'] )){
                $values = $_POST['district'];
                $districts = implode(",", $values);
            }

            $query="UPDATE `event_".$event_id."_volunteers` SET service_district='$districts',type='$value1',abilities='$data' where NIC_num='$nic'";


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
    $money_amount=0;
    if ($submit_type==="option"){
        $nic=$_SESSION['user_nic'];

        $query="SELECT * FROM `event_".$event_id."_volunteers` where NIC_num='$nic'";
        $result=($con->query($query))->fetch_assoc();
        $service_district=explode(",",$result['service_district']);
        $type=$result['type'];
        $ability=explode(",",$result['abilities']);
        $money_descrip=explode(":",$ability[0]);
        $money_name=$money_descrip[0];
        $money_amount=$money_descrip[1];
        $count_other= count($ability);

    }

    ?>
    <div><label class="head_label">Like to be </label><br>

        <input type="checkbox" name="type[]"  value="Donor" <?php if ($submit_type==="option"){if($type === 'Donor' OR $type === 'Donor & Volunteer' ) echo "checked='checked'"; }?>>Donor
        <input type="checkbox" name="type[]" value="Volunteer" <?php if ($submit_type==="option"){if($type === 'Volunteer' OR $type === 'Donor & Volunteer' ) echo "checked='checked'"; }?>>Volunteer<br/><br/>
    </div>


    <div >
        <label class="head_label"> District/Districts where you want to serve</label>
        <select name="district[]"multiple="multiple" >
            <?php
            $district_arr = array('Ampara','Anurashapura','Badulla','Batticaloa','Colombo','Galle','Gampha','Hambatota','Jaffna','Kaltura','Kandy',
                'Kegalle','Kilinochchi','Kurunegala','Mannar','Matale','Mathara','Moneragala','Mullaitivu','Nuwara-Eliya','Polonnaruwa','Puttalam',
                'Ratnapura','Tricomalee','Vavuniya');
            foreach($district_arr as $dis){
                echo "<option value='".$dis."'>".$dis."</option>";
            }
            ?>
            <!--
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
            -->
        </select><br><br>
    </div>

    <div><label class="head_label">Abilities </label><br>
        <table id="volunteer_table">
            <tr>
                <td class=des_area>
                    <div >
                        <input class="input_box" name="money" id="money" value="<?php if ($submit_type==="option"){ echo $money_name;}else {echo "Money";}?>"></input>

                    </div>
                </td>
                <td class=des_area>
                    <div >
                        <input  class="input_box" name="amount" id="amount" value="<?php  echo $money_amount?>"></input>
                    </div>
                </td>
                <td class=des_area>
                    Rs
                </td>
            </tr>
            <?php
            if ($submit_type==="option"){
                for ($x = 1; $x <$count_other; $x++) {
                    $other_descrip=explode(":",$ability[$x]);
                    $other_name=$other_descrip[0];
                    $other_quantity=$other_descrip[1];
                    echo "<table>";
                    echo "<tr>";
                    echo "<td class=des_area>";
                    echo "<div >";
                    echo '<input class="input_box" name="things[]" value='.$other_name.'></input>';
                    echo "</div>";
                    echo "</td>";
                    echo "<td class=des_area>";
                    echo '<div>';
                    echo '<input  class="input_box" name="quantity[]" value='.$other_quantity.'></input>';
                    echo "</div>";
                    echo "</td>";
                }
            }
            ?>
        </table>
        <input name="update_button" type="button"  value="Add other" onclick="add_option()">
    </div>
    <br>
    <br>
    <div>
        <input name="update_button" type="submit"  value="Submit"  class="login_button">
        <button id=close_request_popup class=submit_button>Cancel</button>

    </div>

</form>