<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";

    $query = "select id, note from fundraising_pro_don where by_person = '".$_SESSION['user_nic']."' and for_fund = ".$_GET['id'].";
    select * from fundraisings where id=".$_GET['id'].";
    select * from civilian_detail where NIC_num=(
        select by_civilian from fundraisings where id=".$_GET['id']."
    );
    select org_name from organizations where org_id=(
        select by_org from fundraisings where id=".$_GET['id']."); 
    select name from disaster_events where event_id=(
        select for_event from fundraisings where id=".$_GET['id'].");
    select * from fundraisings_expects where fund_id=".$_GET['id'].";
    select * from fundraising_pro_don_content where don_id=(
        select id from fundraising_pro_don where by_person = '".$_SESSION['user_nic']."' and for_fund = ".$_GET['id']."
    );";
?> 

<!DOCTYPE html>
<html>
    <head>
        <script src='/js/fundraising_donate.js'></script>
        <link rel="stylesheet" href='/css_codes/donate_index.css'>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
    
    </head>
    <body>
        <script>
            btnPress(7);
        </script>
        <?php
            if(mysqli_multi_query($con,$query)){
                echo '<div  id="form_box">';
                echo "<form method='post' action='index_php.php'>";
                echo "<input type='hidden' name='for_fund' value='{$_GET['id']}'>";
                    $old_note='';
                    $is_exist=false;
                    $result = mysqli_store_result($con);
                    if(mysqli_num_rows($result)>0){
                        $is_exist=true;
                        $old_fund = mysqli_fetch_assoc($result);
                        mysqli_free_result($result);
                        $old_note=$old_fund['note'];
                        echo "<input type='hidden' name='entry_update_id' value='{$old_fund['id']}'>";
                    }
                    else{
                        mysqli_fetch_all($result,MYSQLI_ASSOC);
                        echo "<input type='hidden' name='entry_update_id' value='0'>";
                    }
                    mysqli_next_result($con);
                    $result = mysqli_store_result($con);
                    $fundraising_detail= mysqli_fetch_assoc($result);
                    $fundraising_name =$fundraising_detail['name'];
                    $by_civilian = $fundraising_detail['by_civilian'];
                    mysqli_free_result($result);

                    mysqli_next_result($con);
                    $result = mysqli_store_result($con);
                    $civi_detail = mysqli_fetch_assoc($result);
                    mysqli_free_result($result);

                    mysqli_next_result($con);
                    $result = mysqli_store_result($con);
                    $org_name_result=mysqli_fetch_assoc($result);
                    $org_name_fundraising = (isset($org_name_result['org_name']))?$org_name_result['org_name']:'';
                    mysqli_free_result($result);

                    mysqli_next_result($con);
                    $result = mysqli_store_result($con);
                    $event_name_result=mysqli_fetch_assoc($result);
                    $event_name_fundraising = (isset($event_name_result['name']))?$event_name_result['name']:'';
                    mysqli_free_result($result);

                    mysqli_next_result($con);
                    $result = mysqli_store_result($con);
                    $fund_expect = mysqli_fetch_all($result,MYSQLI_ASSOC);
                    mysqli_free_result($result);

                    mysqli_next_result($con);
                    $result = mysqli_store_result($con);
                    $old_content = mysqli_fetch_all($result,MYSQLI_ASSOC);
                    mysqli_free_result($result);

                    $add_element =  "<div class='input_sub_container'>
                                <div class='item_amount_div'>
                                    <div class='item_div'>
                                        <input type='text' name='item[]' class='text_input request_input' placeholder='item' onchange='input_set(this)'>
                                    </div>
                                    <div class='amount_div'>
                                        <input type='text' name='amount[]' class='text_input request_input' placeholder='amount' onchange='input_set(this)'>
                                    </div>
                                </div>
                                <div class='status_div'>
                                    <div class='toggle btn btn-waarning off' data-toggle='toggle' style='width: 100px; height: 15px;' onclick='click_checkbox(this)'>
                                        <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='checkbox_change(this)'>
                                        <input type='hidden' name='mark[]' value='promise'>
                                        <div class='toggle-group'>
                                            <label class='btn btn-success toggle-on' style='line-height: 20px;'>
                                                Helped
                                            </label>
                                            <label class='btn btn-warning active toggle-off' style='line-height: 20px;'>
                                                Not helped
                                            </label>
                                            <span class='toggle-handle btn btn-default'></span>
                                        </div>
                                    </div>
                                </div>
                                <div class='button_div'>
                                    <button type='button' onclick='add_input(this)' class='butn'>Add</button>
                                </div>
                                <input type='hidden' name='update_id[]' value='0'>
                            </div>";

                    echo '<div class=dis_container>';
                        echo '<div class="requester_detail">';
                            echo '<a class="all_a" href="">';
                                echo "".$fundraising_name."";
                            echo '</a></div>';
                        echo '<div class="request_detail_head">Fundraising Details</div>';
                        echo '<div class="request_detail">';
                        echo '<table class="table1">';
                        echo '<tr>';
                        echo '<td> Author:</td>';
                        echo '<td>' . $civi_detail['first_name'] ." ". $civi_detail['last_name']. '</td>';
                        echo '</tr>';
                    
                        if($fundraising_detail['by_org']!=NULL){
                            echo '<tr><td> Org name:</td><td>' . $org_name_fundraising . '</td></tr>';
                        }
                        if($fundraising_detail['for_event']==NULL){
                            echo '<tr><td> Purpose:</td><td>' . $fundraising_detail['for_any']. '</td></tr>';
                        }else{
                            echo '<tr><td>Purpose:</td><td>' .$event_name_fundraising. '</td></tr>';
                        }
                        $content="";
                        foreach($fund_expect as $row_req){
                            $content.=$row_req['item']." : ".$row_req['amount']."<br>";
                        }
                        echo '<tr><td> Expected funds:</td><td>' . $content. '</td></tr>';
                        function filter($input){
                            return(htmlspecialchars(stripslashes(trim($input))));
                        }                      
                        echo '<tr>';
                            echo '<td>Service area: </td>';
                            echo '<td>'.$fundraising_detail["service_area"].' </td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td>description: </td>';
                            echo '<td>'.$fundraising_detail["description"].'</td>';
                        echo '</tr>';                      
                        echo '</table>';
                echo '</div>';
                echo '<div class="for_bottom_div">';
                echo '</div>';
            echo '</div>';
                    if($is_exist==true){
                        echo '<div id="old_promise">';
                        echo '<div class=head_label_container><label class="head_label">';
                        echo "My promises";
                        echo '</label></div>';     
                            $your_promise='';
                            foreach($old_content as $row_req){
                               $your_promise.=$row_req['item'].":".$row_req['amount']."<br>";
                            }
                            echo '<div class="request_detail">';
                            echo "<table class=\"table1\">";
                                echo "<tr><td>your promises :</td> <td>".$your_promise."</td></tr>";
                                echo "<tr><td>your note :</td><td> ".($old_note?: "No notes")."</td></tr>";
                            echo "</table>";
                            echo '</div>';
                            
                            echo '<div class="edit_button_container">';
                                echo '<button type="button" name="pro_edit_button" class="submit_button" onclick="edit_event_promise(this)" id=req_submit_btn >EDIT</button>';
                                echo '<input type="submit" name="pro_cancel_button" class="cancel_button" value="CANCEL PROMISE" id=cancel_btn ></input>';
                            echo '</div>';            
                        echo '</div>';
                    
                        echo "<div id='promise_div' class='old_pro_container promise_div'>";
                    echo '<div class="for_edit_bottom_div">';
                echo '</div>';
                      echo '<div class=head_label_container id="old_donation"><label class="head_label">Edit your old promise</label></div>';
                        echo '<div class="input_container">';
                        foreach($old_content as $row_req){
                            if($row_req['pro_don']=='pending'){
                                $checcked = "checked";
                                $div_class = 'btn-success';
                            }else{
                                $checcked = '';
                                $div_class = 'btn-warning off';
                            }
                            echo "<div class='input_sub_container'>
                                    <div class='item_amount_div'>
                                        <div class='item_div'>
                                            <input type='text' class='text_input request_input' name='item[]' value='".$row_req['item']."' onchange='input_set(this)'>
                                        </div>
                                        <div class='amount_div'>
                                            <input type='text' class='text_input request_input' name='amount[]' value='".$row_req['amount']."' onchange='input_set(this)'>
                                        </div>
                                    </div>
                                    <div class='status_div'>
                                        <div class='toggle btn {$div_class}' data-toggle='toggle' style='width: 100px; height: 15px;' onclick='click_checkbox(this)'>
                                            <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='checkbox_change(this)' {$checcked}>
                                            <input type='hidden' name='mark[]' value='{$row_req['pro_don']}'>
                                            <div class='toggle-group'>
                                                <label class='btn btn-success toggle-on' style='line-height: 20px;'>
                                                    Helped
                                                </label>
                                                <label class='btn btn-warning active toggle-off' style='line-height: 20px;'>
                                                    Not helped
                                                </label>
                                                <span class='toggle-handle btn btn-default'></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='button_div'>
                                        <button type='button' onclick='remove_input(this)' class='butn'>Remove</button>
                                    </div>
                                    <input type='hidden' name='update_id[]' value='{$row_req['id']}'>
                                </div>";
                        }
                        echo $add_element;
                        echo '</div>';
                        echo '<div class="promise_td">';
                        echo '<div class=for_label" ><label name="note" id="note_label">Note:</label></div><textarea col=50 rows=2 id="note" name="note">';
                            echo $old_note;
                        echo '</textarea>';
                echo '</div>';                      
                echo '<div class="pro_button_contaniner">';
                            echo '<button name="edit_button" type="submit"  value="UPDATE PROMISE"  class="edit_button" id=req_submit_btn >UPDATE PROMISE</button>';
                            echo '<button type="submit" name="pro_cancel_button" class="cancel_button" value="CANCEL" id=cancel_btn >CANCEL</button>';
                        echo '</div>';
                    echo '</div>';
        }else{
            echo "<div id='promise_div' class='dis_container promise_div' style='display:block'>";
            echo '<div class=head_label_container><label class="head_label">';
            echo "Add your promise";
            echo '</label></div>';
            echo '<div class="input_container">';
            foreach($fund_expect as $row_req){
                echo "<div class='input_sub_container'>
                        <div class='item_amount_div'>
                            <div class='item_div'>
                                <input type='text' class='text_input request_input' name='item[]' value='".$row_req['item']."' onchange='input_set(this)'>
                            </div>
                            <div class='amount_div'>
                                <input type='text' class='text_input request_input' name='amount[]' value='".$row_req['amount']."' onchange='input_set(this)'>
                            </div>
                        </div>
                        <div class='status_div'>
                            <div class='toggle btn btn-waarning off' data-toggle='toggle' style='width: 100px; height: 15px;' onclick='click_checkbox(this)'>
                                <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='checkbox_change(this)'>
                                <input type='hidden' name='mark[]' value='promise'>
                                <div class='toggle-group'>
                                    <label class='btn btn-success toggle-on' style='line-height: 20px;'>
                                        Helped
                                    </label>
                                    <label class='btn btn-warning active toggle-off' style='line-height: 20px;'>
                                        Not helped
                                    </label>
                                    <span class='toggle-handle btn btn-default'></span>
                                </div>
                            </div>
                        </div>
                        <div class='button_div'>
                            <button type='button' onclick='remove_input(this)' class='butn'>Remove</button>
                        </div>
                        <input type='hidden' name='update_id[]' value='0'>
                    </div>";
        }
            echo $add_element;
                
            echo '</div>';
            echo '<div class="promise_td">';
            echo '<div class="for_label" >';
                        echo '<label id="note_label">Note:</label>';
                        echo '</div>';
                        echo '<textarea col=30 rows=1 id="note" name="note"></textarea>';
            echo '</div>';

            echo '<div class="pro_button">';
                echo '<input name="submit_button" type="submit"  value="PROMISE"  class="submit_button" id=req_submit_btn >';
                echo '<button type="submit" name="pro_cancel_button" class="cancel_button" value="CANCEL" id=cancel_btn >CANCEL</button>';

            echo '</div>';
        echo '</div>';
    }                
echo "<input id='del_detail' type='hidden' name='del' value=''>";
echo '</form>';
echo '</div>';
}

?>
</body>
</html>
<script>
var add_element = "<?php echo str_replace(array("\n","\r","\r\n"),'',$add_element) ?>";
</script>