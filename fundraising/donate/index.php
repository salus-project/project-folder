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
    </head>
    <body>
        <script>
            btnPress(7);
        </script>
        <?php
            if(mysqli_multi_query($con,$query)){
                echo '<div class="form_div">';
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

                    echo '<div id="title">';
                        echo "<center><b>".$fundraising_name."</b></center>";
                    echo '</div>';
                    echo '<div class="table_div">';
                        echo '<table class="donate_tab">';           
                            echo '<tr id="fudraising_detail"><td colspan="2"> <b> Fundraising Details</b></td></tr>'  ;      
                            echo '<tr><td class=column1> Created by </td><td class=column2>' . $civi_detail['first_name'] ." ". $civi_detail['last_name']. '</td></tr>';                              
                            
                            if($fundraising_detail['by_org']!=NULL){
                                echo '<tr><td class=column1> Org name</td><td class=column2>' . $org_name_fundraising . '</td></tr>';
                            }
                            if($fundraising_detail['for_event']==NULL){
                                echo '<tr><td class=column1> Purpose</td><td class=column2>' . $fundraising_detail['for_any']. '</td></tr>';
                            }else{
                                echo '<tr><td class=column1>Purpose</td><td class=column2>' .$event_name_fundraising. '</td></tr>';
                            }
                            $content="";
                            foreach($fund_expect as $row_req){
                                $content.=$row_req['item']." : ".$row_req['amount']."<br>";
                            }
                            echo '<tr class="item_amount"><td class=column1> Expected funds</td><td class=column2>' . $content. '</td></tr>';
                            function filter($input){
                                return(htmlspecialchars(stripslashes(trim($input))));
                            }                      
                            echo '<tr>';
                                echo '<td class="column1">Service area </td>';
                                echo '<td class="column2">'.$fundraising_detail["service_area"].' </td>';
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td class="column1">description </td>';
                                echo '<td class="column2">'.$fundraising_detail["description"].'</td>';
                            echo '</tr>';                      
                        echo '</table>';    
                    echo '</div>'; 

                    if($is_exist==true){
                        echo '<div class="old_promise_div">';
                            echo '<div class="my_promise_div"><b>My promises</b></div>';
                            echo '<div>';      
                            $your_promise='';
                            foreach($old_content as $row_req){
                               $your_promise.=$row_req['item'].":".$row_req['amount']."<br>";
                            }
                            echo "<table>";
                                echo "<tr><td>your promises </td> <td>".$your_promise."</td></tr>";
                                echo "<tr><td>your note </td><td> ".($old_note?: "No notes")."</td></tr>";
                            echo "</table>";
                            
                            echo '<div class="edit_cancel_button">';
                                echo '<button type="button" name="pro_edit_button" class="edit_button" onclick="edit_my_promise(this)" id=edit_btn >EDIT</button>';      
                                echo '<input type="submit" name="pro_cancel_button" class="cancel_button" value="CANCEL PROMISE" id=cancel_btn ></input>';
                            echo '</div>';            
                        echo '</div>';
                    
                        echo '<div id="old_promise_edit" class="old_promise_edit">'; 
                            echo '<div class=head_label_container id="old_donation">Your Promises</div>';
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
                                        echo    "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                                        echo    "<input type='checkbox' onchange='checkbox_fun(this)' {$checcked}>";
                                        echo    "<input type='hidden' name='mark[]' value='{$row_req['pro_don']}'>";
                                        echo    "<input type='hidden' name='update_id[]' value='{$row_req['id']}'>";
                                        echo "</div>";
                                    }
                            
                                    echo '<div class="input_sub_container">';
                                        echo '<input type="text" name="item[]" class="text_input request_input">';
                                        echo '<input type="text" name="amount[]" class="text_input request_input">';
                                        echo '<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>';
                                        echo    "<input type='checkbox' onchange='checkbox_fun(this)'>";
                                        echo    "<input type='hidden' name='mark[]' value='promise'>";
                                        echo    "<input type='hidden' name='update_id[]' value='0'>";
                                    echo '</div>';
                                echo '</div>';
                                echo "<textarea name='note'>".$old_note."</textarea><br>";
                                echo '<input id=promise_but type="submit" name=pro_submit_button value="PROMISE" >'; 
                        
                            echo '</div>';
                        echo "</div>";
                    }else{
                        echo '<div class="table_div">'; 
                            echo '<div class=head_label_container id="old_donation">Your Promises</div>';
                            echo '<div class="input_container">';
                                echo '<div class="input_sub_container">';
                                    echo '<input type="text" name="item[]" class="text_input request_input">';
                                    echo '<input type="text" name="amount[]" class="text_input request_input">';
                                    echo '<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>';
                                    echo    "<input type='checkbox' onchange='checkbox_fun(this)'>";
                                    echo    "<input type='hidden' name='mark[]' value='promise'>";
                                    echo    "<input type='hidden' name='update_id[]' value='0'>";
                                echo '</div>';
                            echo "</div>";
                            echo "<textarea name='note'></textarea>";
                            echo '<input id=promise_but type="submit" name=pro_submit_button value="PROMISE" >';     
                        echo '</div>'; 
                    }
                    echo "<input id='del_detail' type='hidden' name='del' value=''>";
                    echo "</form>";
                echo '</div>';
            }
        ?>
    </body>
</html>