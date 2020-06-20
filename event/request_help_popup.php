<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $event_id = $_GET['event_id'];
    $query = "select * from event_".$event_id."_help_requested where NIC_num = '".$_SESSION['user_nic']."'";
    $result=$con->query($query)->fetch_assoc();
    
    if($result!=null){
        $old_district = $result['district'] ?: '';
        $old_village = $result['village'] ?: '';
        $old_street = $result['street'] ?: '';
        $old_requests = $result['requests'] ?: '';
    }else{
        $old_district=$old_street=$old_village='';
        $old_requests='money:0';
    }
    $old_requests = array_filter(explode(",",$old_requests));

?>
<link rel='stylesheet' type='text/css' href='/css_codes/request.css'>
<div  class="form_box">
    <div class=dis_container>
        <table>
            <tr>
                <td>
                    <label class="head_label"> District (current) </label>
                </td>
                <td>
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
                </td>
            </tr>
            <tr>
                <td>
                    <label class="head_label"> Village </label>
                </td>
                <td>
                    <input type="text" value="<?php echo $old_village ?>" id="village">
                </td>
            </tr>
            <tr>
                <td>
                    <label class="head_label"> Street </label>
                </td>
                <td>
                    <input type="text" value="<?php echo $old_street ?>" id="street">
                </td>
            </tr>
        </table>
    </div>


    <div class=head_label_container><label class="head_label"> Requests </label></div>



    <div class="input_container">

        <?php
            foreach($old_requests as $row_req){
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
            <input type="text" class='text_input request_input'>
            <input type="text" class='text_input request_input'>
            <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
        </div>
    </div>
    <div class=buttons>
        <input name="submit_button" type="submit"  value="Request"  class="submit_button" id=req_submit_btn onclick="submit_request(this.parentElement.parentElement)">
        <button id=close_request_popup class=submit_button>Cancel</button>
    </div>
</div>

