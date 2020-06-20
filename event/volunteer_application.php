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

            $data="Money:0";
            if( ! empty( $_POST['thing_type'] )){
                $data="";
                $things = $_POST['thing_type'];
                $quantity = $_POST['quantity'];
                $count_arr = count($_POST['thing_type']);
                if($things[$count_arr-1]==""){
                    for ($x = 0; $x <$count_arr-2; $x++) {
                        $data=$data.$things[$x].":".$quantity[$x].",";
                    }
                    $data=$data.$things[$count_arr-2].":".$quantity[$count_arr-2];}
                else{
                    for ($x = 0; $x <$count_arr-1; $x++) {
                        $data=$data.$things[$x].":".$quantity[$x].",";
                    }
                    $data=$data.$things[$count_arr-1].":".$quantity[$count_arr-1];}

            }
            $districts="not_selected";
            if( ! empty( $_POST['district'] )){
                $values = $_POST['district'];
                $districts = implode(",", $values);
            }


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
            $data="Money:0";
            if( ! empty( $_POST['thing_type'] )){
                $data="";
                $things = $_POST['thing_type'];
                $quantity = $_POST['quantity'];
                $count_arr = count($_POST['thing_type']);
                if($things[$count_arr-1]==""){
                    for ($x = 0; $x <$count_arr-2; $x++) {
                        $data=$data.$things[$x].":".$quantity[$x].",";
                    }
                    $data=$data.$things[$count_arr-2].":".$quantity[$count_arr-2];}
                else{
                    for ($x = 0; $x <$count_arr-1; $x++) {
                        $data=$data.$things[$x].":".$quantity[$x].",";
                    }
                    $data=$data.$things[$count_arr-1].":".$quantity[$count_arr-1];}

            }



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
<link rel="stylesheet" href="/css_codes/volunteer_application.css">
<form  class="form_box" action="volunteer_application.php" method="POST">
    <input type=hidden name=event_id value="<?php echo $_GET['event_id'] ?>">
    <input type=hidden name=method value='<?php echo $submit_type ?>'>

    <?php
    $ability[0]="money:0";
    if ($submit_type==="option"){
        $nic=$_SESSION['user_nic'];

        $query="SELECT * FROM `event_".$event_id."_volunteers` where NIC_num='$nic'";
        $result=($con->query($query))->fetch_assoc();
        $service_district=explode(",",$result['service_district']);
        $type=$result['type'];
        $ability=explode(",",$result['abilities']);
    }

    ?>

    <div><label class="head_label">Like to be </label><br>

        <input type="checkbox" name="type[]"  value="Donor" <?php if ($submit_type==="option"){if($type === 'Donor' OR $type === 'Donor & Volunteer' ) echo "checked='checked'"; }?>>Donor
        <input type="checkbox" name="type[]" value="Volunteer" <?php if ($submit_type==="option"){if($type === 'Volunteer' OR $type === 'Donor & Volunteer' ) echo "checked='checked'"; }?>>Volunteer<br/><br/>
    </div>


    <div >
        <label class="head_label"> District/Districts where you want to serve</label>
        <div class="dropdown">
            <button type="button" onclick="show_menu()" class="dropbtn">District</button>
            <div id="myDropdown" class="dropdown-content drp">
                <?php
                $district_arr = array('Ampara','Anurashapura','Badulla','Batticaloa','Colombo','Galle','Gampha','Hambatota','Jaffna','Kaltura','Kandy',
                    'Kegalle','Kilinochchi','Kurunegala','Mannar','Matale','Mathara','Moneragala','Mullaitivu','Nuwara-Eliya','Polonnaruwa','Puttalam',
                    'Ratnapura','Tricomalee','Vavuniya');
                foreach($district_arr as $dis){
                    echo "<a class='drp' data-value='$dis' onclick=select_option(this)>";
                    echo "<label class=\"container drp\">$dis";
                    if ($submit_type==="option"){
                        if(in_array($dis, $service_district)){
                            echo "<input type=\"checkbox\" class=\"drp\" name=\"district[]\" value=\"$dis\" checked=\"checked\">
                                <span class=\"checkmark drp\"></span>
                        </label>
                        </a>";}

                        else{echo "<input type=\"checkbox\" class=\"drp\" name=\"district[]\" value=\"$dis\" >
                            <span class=\"checkmark drp\"></span>
                    </label>
                    </a>";

                        }}
                    else{echo "<input type=\"checkbox\" class=\"drp\" name=\"district[]\" value=\"$dis\" >
                        <span class=\"checkmark drp\"></span>
                </label>
                </a>";

                    }
                }

                ?>
            </div>
        </div>
    </div>


    <div class=head_label_container><label class="head_label"> Abilities </label></div>



    <div class="input_container">

        <?php
            foreach($ability as $row_req){
                $arr = explode(":",$row_req);
                echo "<div class=\"input_sub_container\">";
                echo    "<input type='text' class='text_input request_input' value='".$arr[0]."' ";

                echo        " >
                        <input type='text' class='text_input request_input' value='".$arr[1]."'>";
                echo    "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                echo "</div>";
            }
        ?>
        <div class="input_sub_container">
            <input type="text" class='text_input request_input' name='thing_type[]'>
            <input type="text" class='text_input request_input'  name='quantity[]'>
            <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
        </div>
    </div>


    <br>
    <br>
    <div>
        <input name="update_button" type="submit"  value="Submit"  class="login_button">
        <button id=close_request_popup class=submit_button>Cancel</button>

    </div>

</form>