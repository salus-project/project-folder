<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $event_id = $_GET['event_id'];
    $nic=$_SESSION['user_nic'];
    $query = "select * from event_".$event_id."_volunteers where NIC_num = '".$_SESSION['user_nic']."';
    SELECT * from disaster_events where event_id='".$event_id."';
    select * from event_".$event_id."_abilities where donor = '".$_SESSION['user_nic']."';";

    if(mysqli_multi_query($con,$query)){
        echo "<form method='post' action='volunteer_application_php.php'>";
            echo "<input type='hidden' name='event_id' value='".$event_id."'>";
        $result=mysqli_store_result($con); 
 
        if(mysqli_num_rows($result)>0){
            $old_ability=mysqli_fetch_assoc($result);
            $old_district = $old_ability['service_district'] ?: '';
            $old_district = explode(",", $old_district);
            $old_type=$old_ability['type'] ?: '';
            mysqli_free_result($result);
            echo "<input type='hidden' name='entry_update_id' value='{$old_ability['NIC_num']}'>";
        }else{
            $old_district='';
            $old_type='';
            mysqli_fetch_all($result,MYSQLI_ASSOC);
            echo "<input type='hidden' name='entry_update_id' value='0'>";
        }
        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $old_status=mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        echo "<input type='hidden' name='status' value='{$old_status['user_'.$_SESSION['user_nic']]}'>";

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $old_content = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
    }

?>
<link rel="stylesheet" href="/css_codes/volunteer_application.css">
<form  class="form_box" action="volunteer_application.php" method="POST">
    <input type=hidden name=event_id value="<?php echo $_GET['event_id'] ?>">
    <input type=hidden name=method value='<?php echo $submit_type ?>'>

    <div><label class="head_label">Like to be </label><br>

        <input type="checkbox" name="type[]"  value="Donor" <?php if($old_type === 'Donor' OR $old_type === 'Donor&Volunteer' ) echo "checked='checked'"; ?>>Donor
        <input type="checkbox" name="type[]" value="Volunteer" <?php if($old_type === 'Volunteer' OR $old_type === 'Donor&Volunteer' ) echo "checked='checked'"; ?>>Volunteer<br/><br/>
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
                    if ($old_district!=''){
                        if(in_array($dis, $old_district)){
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
            foreach($old_content as $row_req){
                echo "<div class=\"input_sub_container\">";
                echo    "<input type='text' class='text_input request_input' name='item[]' value='".$row_req['item']."'>
                        <input type='text' class='text_input request_input' name='amount[]' value='".$row_req['amount']."'>";
                echo    "<button type='button' onclick='remove_ability_input(this)' class='add_rem_btn'>Remove</button>";
                echo "<input type='hidden' name='update_id[]' value='".$row_req['id']."'>";
                echo "</div>";
            }
        ?>
        <div class="input_sub_container">
            <input type="text" name='item[]' class='text_input request_input'>
            <input type="text" name='amount[]' class='text_input request_input'>
            <button type="button" onclick="add_ability_input(this)" class="add_rem_btn">Add</button>
            <input type='hidden' name='update_id[]' value='0'>
        </div>
    </div>
    <br>
    <br>
    <div>
        <input name="update_button" type="submit"  value="Submit"  class="login_button">
        <button id=close_request_popup name='cancel_button' class=submit_button>Cancel</button>

    </div>
</div>
<?php echo "<input id='del_details' type='hidden' value='' name='del_details'>" ; ?>
</form>