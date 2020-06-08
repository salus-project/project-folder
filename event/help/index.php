<?php
   // require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $to=$_GET['to'];
    $event_id = $_GET['event_id'];
    $by=$_GET['by'];
    
    
    $query = "select * from event_".$event_id."_help_requested where NIC_num = '".$to."'";
    $result=$con->query($query)->fetch_assoc();
    
    if($result!=null){
        $old_district = $result['district'] ?: '';
        $old_village = $result['village'] ?: '';
        $old_street = $result['street'] ?: '';
        $old_requests = $result['requests'] ?: '';
    }else{
        $old_district=$old_street=$old_village=$old_requests='';
    }
    $old_requests = array_filter(explode(",",$old_requests));
?>

<!DOCTYPE html>
    <head>
        <link rel='stylesheet' type='text/css' href='/css_codes/help_event_individual.css'>
        <script src='/js/help_event_individual.js' type="text/javascript"></script>
    </head>
    <body>

        <div  id="form_box">
            <form method="POST" action=<?php echo "index_php.php";?>> 
            <input type="hidden" name="event_id" value= <?php echo $event_id;?>>
            <input type="hidden" name="to" value= <?php echo $to;?>>
            <input type="hidden" name="by" value= <?php echo $by;?>>
            <div class=dis_container>
                <table class="table1">
                    <tr ><td colspan="2" id="request_detail"><b>Requested details<b></tr></td>
                    <tr>
                        <td> District (current) :</td>
                        <td><?php echo $old_district ?> </td>
                    </tr>
                    <tr>
                        <td>Village :</td>
                        <td><?php echo $old_village ?></td>
                    </tr>
                    <tr>
                        <td>Street :</td>
                        <td><?php echo $old_street ?><br></td>
                    </tr>
                    <tr id="request_tr">
                        <td> Requests :</td>
                        <?php
                            $request="";
                            foreach($old_requests as $row_req){
                               $request.=$row_req."<br>";
                            }
                        ?>
                        <td><?php echo $request?></td>
                    </tr>
                            
                </table>
            </div>
            <?php      
            echo $by;            
                if($by=="your_self"){
                    $data="SELECT * from event_".$event_id."_pro_don where by_person='199872641943' and to_person='".$to."'";     
                }else{
                    $by_org=$by;
                    $data="SELECT * from event_".$event_id."_pro_don where by_org='".$by_org."' and to_person='".$to."'";           
                }
                $result1=$con->query($data);
                if($result1->num_rows>0){
                    $result2=$result1->fetch_assoc();

                    echo '<div id="old_promise">';
                        echo '<div class=head_label_container><label class="head_label"> <b>My promises</b> </label></div>';
                        $old_promise = $result2['content'];
                        $old_promises = array_filter(explode(",",$old_promise));
                        
                        foreach($old_promises as $row_req){
                            echo $row_req."<br>";
                        }
                        echo '<div class="edit_button">';
                        echo '<button type="button"  class="submit_button" onclick="edit_promise(this)" id=req_submit_btn >EDIT</button>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class=dis_container id="promise_div">';
                      /* echo '<div class=head_label_container id="old_donation"></div>';
                        echo '<div class="input_container">';
                            foreach($old_promises as $row_req){
                                $arr = explode(":",$row_req);
                                echo "<div class=\"input_sub_container\">";
                                echo    "<input type='text' class='text_input request_input' name='things[]' value='".$arr[0]."'>";
                                echo    "<input type='text' class='text_input request_input' name='things_val[]' value='".$arr[1]."'>";
                                echo    "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                                echo "</div>";
                            }
                    
                            echo '<div class="input_sub_container">';
                                echo '<input type="text" name="things[]" class="text_input request_input">';
                                echo '<input type="text" name="things_val[]" class="text_input request_input">';
                                echo '<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div id="promise_td">';
                            echo'<table>';
                                echo '<tr><td><label id="note_label">Note</label></td><td><textarea col=30 rows=4 id="note" name="note"></textarea></td></tr>';
                            echo '</table>';

                        echo '</div>';                      
                        echo '<div class="pro_button">';
                            echo '<input name="submit_button" type="submit"  value="PROMISE"  class="submit_button" id=req_submit_btn >';
                        echo '</div>';*/
                    echo '</div>';
                    }
                    else{                
            
                        echo '<div class=dis_container id="promise_div">';
                            echo '<div class=head_label_container><label class="head_label"> <b>Donations<b> </label></div>';

                            echo '<div class="input_container">';
                            
                                foreach($old_requests as $row_req){
                                    $arr = explode(":",$row_req);
                                    echo "<div class=\"input_sub_container\">";
                                    echo    "<input type='text' class='text_input request_input' name='things[]' value='".$arr[0]."'>
                                            <input type='text' class='text_input request_input' name='things_val[]' value='".$arr[1]."'>";
                                    echo    "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                                    echo "</div>";
                                }
                        
                                echo '<div class="input_sub_container">';
                                    echo '<input type="text" name="things[]" class="text_input request_input">';
                                    echo '<input type="text" name="things_val[]" class="text_input request_input">';
                                    echo '<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>';
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
                ?>
            </form>
        </div>
    </body>
</html>