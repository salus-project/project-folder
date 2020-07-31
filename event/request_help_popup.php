<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $event_id = $_GET['event_id'];
    $query = "select * from event_".$event_id."_help_requested where NIC_num = '".$_SESSION['user_nic']."';
    SELECT * from disaster_events where event_id='".$event_id."';
    select * from event_".$event_id."_requests where requester = '".$_SESSION['user_nic']."';";
    
    if(mysqli_multi_query($con,$query)){
        
        echo "<form method='post' action='request_help.php'>";
            echo "<input type='hidden' name='event_id' value='".$event_id."'>";
        $result=mysqli_store_result($con); 
 
        if(mysqli_num_rows($result)>0){
            
            $old_request=mysqli_fetch_assoc($result);
            $old_district = $old_request['district'] ?: '';
            $old_village = $old_request['village'] ?: '';
            $old_street = $old_request['street'] ?: '';
        
            mysqli_free_result($result);
            echo "<input type='hidden' name='entry_update_id' value='{$old_request['NIC_num']}'>";
        }else{
            $old_district=$old_street=$old_village='';
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

<form  class="form_box">
    <div class=dis_container>
        <div class=head_lab_container><label class="head_label"> District (current) </label></div>
        <div class=dis_input_container>
                <select name="district" class="dis_selection" id="district">
                    <?php
                        $district_arr = array('Ampara','Anurashapura','Badulla','Batticaloa','Colombo','Galle','Gampha','Hambatota','Jaffna','Kaltura','Kandy',
                            'Kegalle','Kilinochchi','Kurunegala','Mannar','Matale','Mathara','Moneragala','Mullaitivu','Nuwara-Eliya','Polonnaruwa','Puttalam',
                            'Ratnapura','Tricomalee','Vavuniya');
                        foreach($district_arr as $dis){
                            echo "<option value='".$dis."' ";
                            if(strtolower($dis)==strtolower($old_district)){
                                echo "selected";
                            }
                            echo ">".$dis."</option>";
                        }
                    ?>
                </select>
                </div>
    </div>
    <div class=village_container>
        <label class="head_label"> Village </label>
        <input type="text" name='village' value="<?php echo $old_village ?>" class="village_input" id="village">
    </div>
    <div class=street_container>
        <label class="head_label"> Street </label>
        <input type="text" name="street" value="<?php echo $old_street ?>"class="street_input" id="street">
    </div>

    <div class="request_ability_container"><label class="head_label"> Requests </label></div>
    <div class="req_input_container">
        <?php
            foreach($old_content as $row_req){
                echo "<div class=\"input_sub_container\">";
                echo    "<input type='text' class='text_input request_input' name='item[]' value='".$row_req['item']."'>
                        <input type='text' class='text_input request_input' name='amount[]' value='".$row_req['amount']."'>";
                echo    "<button type='button' onclick='remove_request_input(this)' class='text_input butn'>Remove</button>";      
                echo    "<input type='hidden' name='update_id[]' value='".$row_req['id']."'>";
                echo "</div>";
            }
        ?>
        <div class="input_sub_container">
            <input type="text" name='item[]' class='text_input request_input'>
            <input type="text" name='amount[]' class='text_input request_input'>
            <button type="button" onclick="add_request_input(this)" class="text_input butn">Add</button>
            <input type='hidden' name='update_id[]' value='0'>
        </div>
    </div>
    <div class="submit_cancel_btn_container">
        <button name="submit_button" type="submit"  value="Request"  class="submit_button" id=req_submit_btn onclick="submit_request(this.parentElement.parentElement)">Request</button>
        <button type='button' id=close_request_popup name='cancel_button' class=submit_button >Cancel</button>
    </div>

<?php echo "<input id='del_details' type='hidden' value='' name='del_details'>" ; ?>
</form>