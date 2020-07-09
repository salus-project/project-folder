<?php
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
    $to=$_GET['to'];
    $event_id = $_GET['event_id'];
    $by=$_GET['by'];
    $by_person=$_SESSION['user_nic'];
    $query = "select event_".$event_id."_help_requested.*, civilian_detail.first_name, civilian_detail.last_name from event_".$event_id."_help_requested inner join civilian_detail on event_".$event_id."_help_requested.NIC_num = civilian_detail.NIC_num where event_".$event_id."_help_requested.NIC_num = '".$to."';
    select * from event_".$event_id."_requests WHERE requester='".$to."';";
    
    if($by=="your_self"){
        $query.="select id, note from event_".$event_id."_pro_don where by_person='".$by_person."' and to_person='".$to."';
        select * from event_".$event_id."_pro_don_content where don_id=(
            select id from event_".$event_id."_pro_don where by_person='".$by_person."' and to_person='".$to."');";
    }else{
        $query.="SELECT id, note from event_".$event_id."_pro_don where by_org='".$by."' and to_person='".$to."';         
        select * from event_".$event_id."_pro_don_content where don_id=(
            select id from event_".$event_id."_pro_don where by_org='".$by."' and to_person='".$to."')";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' type='text/css' href='/css_codes/help_event_individual.css'>
        <script src='/js/help_event_individual.js' type="text/javascript"></script>
    </head>
    <body>
    <?php
        if(mysqli_multi_query($con,$query)){
            echo '<div  id="form_box">';
            echo '<form method="POST" action="index_php.php">' ;
            echo '<input type="hidden" name="event_id" value= '.$event_id.'>';
            echo '<input type="hidden" name="to" value= '.$to.'>';
            echo '<input type="hidden" name="by" value= '.$by.'>';
            
            $result = mysqli_store_result($con);
            $old_result = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            if($old_result!=null){
                $old_district = $old_result['district'] ?: '';
                $old_village = $old_result['village'] ?: '';
                $old_street = $old_result['street'] ?: '';
            }else{
                $old_district=$old_street=$old_village='';
            }

            mysqli_next_result($con);
            $result = mysqli_store_result($con);
            $event_requests = mysqli_fetch_all($result,MYSQLI_ASSOC);
            mysqli_free_result($result);

            mysqli_next_result($con);
            $old_note='';
            $is_exist=false;
            $result = mysqli_store_result($con);
            if(mysqli_num_rows($result)>0){
                $is_exist=true;
                $old_promise = mysqli_fetch_assoc($result);
                mysqli_free_result($result);
                $old_note=$old_promise['note'];
                echo "<input type='hidden' name='entry_update_id' value='{$old_promise['id']}'>";
            }
            else{
                mysqli_fetch_all($result,MYSQLI_ASSOC);
                echo "<input type='hidden' name='entry_update_id' value='0'>";
            }

            mysqli_next_result($con);
            $result = mysqli_store_result($con);
            $old_content = mysqli_fetch_all($result,MYSQLI_ASSOC);
            mysqli_free_result($result);
        
    
            echo '<div class=dis_container>';
                echo '<table class="table1">';
                    echo '<tr ><td colspan="2" id="requester_detail"><b>Requester';
                                echo '<a class="all_a" href="/view_profile.php?id='.$old_result["NIC_num"].'">';
                                    echo $old_result['first_name']." ".$old_result['last_name'];
                                echo '</a><b></tr></td>';
                    echo '<tr ><td colspan="2" id="request_detail"><b>Requested details<b></tr></td>';
                    echo '<tr>';
                        echo '<td> District (current) :</td>';
                        echo '<td>'. $old_district.'</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td>Village :</td>';
                        echo '<td>'. $old_village .'</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td>Street :</td>';
                        echo '<td>'.$old_street .'<br></td>';
                    echo '</tr>';
                    echo '<tr id="request_tr">';
                        echo '<td> Requests :</td>';
                            $request='';
                            foreach($event_requests as $row_req){
                               $request.=$row_req['item'].":".$row_req['amount']."<br>";
                            }
                        echo '<td>'.$request.'</td>';
                    echo '</tr>';
                            
                echo '</table>';
            echo '</div>';
    
                if($is_exist==true){
                    echo '<div id="old_promise">';
                        echo '<div class=head_label_container><label class="head_label">';
                            if($by=="your_self"){
                                echo "Promise on your behalf";
                            }else{
                                if(isset($_GET['org_name'])){
                                    $org_name = $_GET['org_name'];
                                }else{
                                    $org_name = "your organization";
                                }
                                echo "Promise on behalf of ".$org_name;
                            }
                        echo '</label></div>';
                        $your_promise='';
                            foreach($old_content as $row_req){
                               $your_promise.=$row_req['item'].":".$row_req['amount']."<br>";
                            }
                        echo "<table>";
                        echo "<tr><td>your promises :</td> <td>".$your_promise."</td></tr>";
                        echo "<tr><td>your note :</td><td> ".($old_note?: "No notes")."</td></tr>";
                        echo "</table>";
                        echo '<div class="edit_button">';
                            echo '<button type="button"  class="submit_button" onclick="edit_event_promise(this)" id=req_submit_btn >EDIT</button>';
                            echo '<input type="submit" name="pro_cancel_button" class="cancel_button" value="CANCEL" id=cancel_btn ></input>';
                        echo '</div>';
                    echo '</div>';

                    echo "<div id='promise_div' class='dis_container promise_div'>";
                      echo '<div class=head_label_container id="old_donation">Edit your old promise</div>';
                        echo '<div class="input_container">';
                            foreach($old_content as $row_req){
                                if($row_req['pro_don']=='pending'){
                                    $checcked = 'checked="checked"';
                                }else{
                                    $checcked = '';
                                }
                                echo "<div class='input_sub_container'>";
                                echo    "<input type='text' class='text_input request_input' name='item[]' value='".$row_req['item']."'>";
                                echo    "<input type='text' class='text_input request_input' name='amount[]' value='".$row_req['amount']."'>";
                                echo    "<button type='button' onclick='remove_old(this)' class='add_rem_btn'>Remove</button>";
                                echo    "<input type='checkbox' onchange='checkbox_val(this)' {$checcked}>";
                                echo    "<input type='hidden' name='mark[]' value='{$row_req['pro_don']}'>";
                                echo    "<input type='hidden' name='update_id[]' value='{$row_req['id']}'>";
                                echo "</div>";
                            }
                    
                            echo '<div class="input_sub_container">';
                                echo '<input type="text" name="item[]" class="text_input request_input">';
                                echo '<input type="text" name="amount[]" class="text_input request_input">';
                                echo '<button type="button" onclick="add_new(this)" class="add_rem_btn">Add</button>';
                                echo    "<input type='checkbox' onchange='checkbox_val(this)'>";
                                echo    "<input type='hidden' name='mark[]' value='promise'>";
                                echo    "<input type='hidden' name='update_id[]' value='0'>";
                            echo '</div>';
                        echo '</div>';
                        echo '<div id="promise_td">';
                            echo'<table>';
                                echo '<tr><td><label name="note" id="note_label">Note</label></td><td><textarea col=30 rows=4 id="note" name="note">';
                                    echo $old_note;
                                echo '</textarea></td></tr>';
                            echo '</table>';
                        echo '</div>';                      
                        echo '<div class="pro_button">';
                            echo '<input name="edit_button" type="submit"  value="UPDATE PROMISE"  class="edit_button" id=req_submit_btn >';
                        echo '</div>';
                    echo '</div>';
                    }
                    else{                

                        echo "<div id='promise_div' class='dis_container promise_div' style='display:block'>";
                            echo '<div class=head_label_container><label class="head_label">';
                                if($by=="your_self"){
                                    echo "Promise on your behalf";
                                }else{
                                    if(isset($_GET['org_name'])){
                                        $org_name = $_GET['org_name'];
                                    }else{
                                        $org_name = "your organization";
                                    }
                                    echo "Promise on behalf of ".$org_name;
                                }
                            echo '</label></div>';
                            foreach($event_requests as $row_req){
                                echo "<div class='input_sub_container'>";
                                echo    "<input type='text' class='text_input request_input' name='item[]' value='".$row_req['item']."'>";
                                echo    "<input type='text' class='text_input request_input' name='amount[]' value='".$row_req['amount']."'>";
                                echo    "<button type='button' onclick='remove_old(this)' class='add_rem_btn'>Remove</button>";
                                echo    "<input type='checkbox' onchange='checkbox_val(this)'>";
                                echo    "<input type='hidden' name='mark[]' value='promise'>";
                                echo    "<input type='hidden' name='update_id[]' value='0'>";
                                echo "</div>";
                            }

                            echo '<div class="input_container">';
                                echo '<div class="input_sub_container">';
                                    echo '<input type="text" name="item[]" class="text_input request_input">';
                                    echo '<input type="text" name="amount[]" class="text_input request_input">';
                                    echo '<button type="button" onclick="add_new(this)" class="add_rem_btn">Add</button>';
                                    echo "<input type='checkbox' onchange='checkbox_val(this)'>";
                                    echo "<input type='hidden' name='mark[]' value='promise'>";
                                    echo "<input type='hidden' name='update_id[]' value='0'>";
                                echo '</div>';
                            echo '</div>';
                            echo '<div id="promise_td">';
                                echo '<table>';
                                    echo '<tr>';
                                        echo '<td><label id="note_label">Note</label></td>';
                                        echo '<td><textarea col=30 rows=4 id="note" name="note"></textarea></td>';
                                        echo '</tr>';
                                echo '</table>';

                            echo '</div>';

                            echo '<div class="pro_button">';
                                echo '<input name="submit_button" type="submit"  value="PROMISE"  class="submit_button" id=req_submit_btn >';
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