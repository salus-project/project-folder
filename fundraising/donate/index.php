<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $id=$_GET['id'];
    //$by=$_GET['by'];
    $by="3";
    $by_person=$_SESSION['user_nic'];
    $query="select * from fundraisings where id=".$id;
    $result=($con->query($query))->fetch_assoc();
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>view fundraising event</title>
        <link rel="stylesheet" href='/css_codes/donate_index.css'>
    </head>
    <body>
        <script>
            function edit_my_promise(element){
                if(element.innerHTML==="EDIT"){
                    element.innerHTML="Hide Edit";
                }else{
                    element.innerHTML="EDIT";
                }
                var edit_pro = document.getElementById("old_promise_edit");
                edit_pro.classList.toggle("show_edit_divi");
            }
        </script>
        <div class="form_div">
            <form method="POST" action=<?php echo "index_php.php";?>>  
                <input type="hidden" name="id" value= <?php echo $id;?>>
                <input type="hidden" name="by" value= <?php echo $by;?>>        
                <div id="title">
                    <center><b><?php echo $result['name'] ?></b></center>
                </div> 
                <div class="table_div">
                    <table class="donate_tab">
                        <?php               
                            echo '<tr id="fudraising_detail"><td colspan="2"> <b> Fundraising Details</b></td></tr>'  ;      
                            $idd= filter($result['by_civilian']);
                            $query3="select * from civilian_detail where NIC_num='$idd' ";
                            $result3=($con->query($query3))->fetch_assoc();
                            echo '<tr><td class=column1> Created by </td><td class=column2>' . $result3['first_name'] ." ". $result3['last_name']. '</td></tr>';                              
                            
                            if($result['by_org']!=NULL){
                                $query1="select * from organizations where org_id=". $result['by_org'];
                                $result1=($con->query($query1))->fetch_assoc();
                                echo '<tr><td class=column1> Org name</td><td class=column2>' . $result1['org_name'] . '</td></tr>';
                            }
                            if($result['for_event']==NULL){
                                echo '<tr><td class=column1> Purpose</td><td class=column2>' . $result['for_any'] . '</td></tr>';
                            }else{
                                $query2="select * from disaster_events where event_id=". $result['for_event'];
                                $result2=($con->query($query2))->fetch_assoc();
                                echo '<tr><td class=column1>Purpose</td><td class=column2>' . $result2['name'] . '</td></tr>';
                            }
                            
                            echo '<tr><td class=column1> Request</td><td class=column2>' . $result['type'] . '</td></tr>';
                            
                            if($result['type']=="money only"){
                                echo '<tr class="money_thing"><td id=column> Amount in rs</td><td id=column2>' . $result['expecting_money'] . '</td></tr>';
                            }elseif($result['type']=="things only"){
                                $things=explode(",",$result['expecting_things']);
                                $content="";
                                for($x=0 ; $x < count($things) ; $x++){
                                    $content.=$things[$x]."<br>";
                                }
                                echo '<tr class="money_thing"><td id=column> Requested things </td><td id=column2>' . $content . '</td></tr>';
                            }else{
                                $content="";
                                $content.="money:".$result['expecting_money']."<br>";
                                $things=explode(",",$result['expecting_things']);
                                for($x=0 ; $x < count($things) ; $x++){
                                    $content.=$things[$x]."<br>";
                                }
                                echo '<tr class="money_thing"><td id=column> Money and Requested things </td><td id=column2>' . $content . '</td></tr>';
                            }
                            function filter($input){
                                return(htmlspecialchars(stripslashes(trim($input))));
                                }
                        ?>                        
                        <tr>
                            <td>Service area </td>
                            <td><?php echo $result['service_area'] ?></td>
                        </tr>
                        <tr>
                            <td>description </td>
                            <td><?php echo $result['description'] ?></td>
                        </tr>                      
                    </table>     
                </div>  

                <?php
                echo '<div class="old_promise_div">';
                    if($by=="your_self"){
                        $query4="select * from fundraising_pro_don where for_fund='".$id."' and by_person='".$by_person."'";
                    }else{
                        $by_org=$by;
                        $query4="select * from fundraising_pro_don where for_fund='".$id."' and by_org='".$by_org."'";
                    }  
                    $result4=$con->query($query4);
                    if($result4->num_rows>0){
                        $result5=$result4->fetch_assoc();
                        echo '<div id="old_promise1" class="old_promise_div1">';
                            echo '<div class="my_promise_div"><b>My promises</b></div>';
                            echo '<div>';
                                $old_promise = $result5['content'];
                                $old_promises = explode(",",$old_promise);
                                
                                foreach($old_promises as $row_req){       
                                    echo $row_req."<br>";
                                }
                                echo "your note : ".($result5['note'] ?: "No notes");
                            echo '</div>';
                            
                            echo '<div class="edit_cancel_button">';
                                echo '<button type="button" name="pro_edit_button" class="edit_button" onclick="edit_my_promise(this)" id=edit_btn >EDIT</button>';      
                                echo '<input type="submit" name="pro_cancel_button" class="cancel_button" value="CANCEL" id=cancel_btn ></input>';
                            echo '</div>';            
                        echo '</div>';
                echo '</div>';

                        echo '<div id="old_promise_edit" class="old_promise_edit">'; 
                            echo '<table class="donate_tab">';
                                $old_thing_value=array();
                                foreach($old_promises as $x){
                                    $y=explode(":","$x");
                                    array_push($old_thing_value,$y[0],$y[1]);
                            
                                }

                                if($result['type']=="money only"){
                                    echo '<tr><td id="promise_td"> Amount in rs</td><td id="promise_td"><input type="text" id="money" value="'.$old_thing_value[1].'" name="donation[]"></td></tr>';
                                }elseif($result['type']=="things only"){
                                    
                                    $things=explode(",",$result['expecting_things']);
                                    for($value=0 ; $value<count($things) ; $value++){
                                        echo '<tr><td id=column1>'.(explode(":",$things[$value]))[0].' </td><td id=column2> <input type="text" value="'.$old_thing_value[2*$value+1].'" id="things" name="donation[]"></td></tr>';
                                    }
                                }else{
                                    echo '<tr><td id="promise_td"> Amount in rs</td><td id="promise_td"><input type="text" id="money" value="'.$old_thing_value[1].'" name="donation[]"></td></tr>';         
                                    $things=explode(",",$result['expecting_things']);
                                    for($value=0 ; $value<count($things) ; $value++){
                                        echo '<tr><td id=column1>'. (explode(":",$things[$value]))[0].' </td><td id=column2> <input type="text" id="things" value="'.$old_thing_value[2*$value+3].'" name="donation[]"></td></tr>';
                                    }
                                }
                            
                                echo '<tr><td id="promise_td">Note</td><td><textarea col=30 rows=4 id="promise_td" name="note"></textarea></td></tr>';
                                echo '<tr><td ><input id=promise_but type="submit" name=pro_edit_button value="EDIT_PROMISE" ></td></tr>';
                            echo '</table>';    
                        echo '</div>';

                    }else{    
                ?>
                        <div class="table_div"> 
                            <table class="donate_tab">
                                <?php
                                    if($result['type']=="money only"){
                                        echo '<tr><td id="promise_td"> Amount in rs</td><td id="promise_td"><input type="text" id="money" name="donation[]"></td></tr>';
                                    }
                                    elseif($result['type']=="things only"){
                                       
                                        $things=explode(",",$result['expecting_things']);
                                        foreach($things as $value){
                                            echo '<tr><td id=column1>'.(explode(":",$value))[0].' </td><td id=column2> <input type="text" id="things" name="donation[]"></td></tr>';
                                        }
                                    }else{
                                        echo '<tr><td id="promise_td"> Amount in rs</td><td id="promise_td"><input type="text" id="money" name="donation[]"></td></tr>';
                                        $query="select * from fundraisings where id=".$id;
                                        $result=($con->query($query))->fetch_assoc();
                                        $things=explode(",",$result['expecting_things']);
                                        foreach($things as $value){
                                            echo '<tr><td id=column1>'. (explode(":",$value))[0].' </td><td id=column2> <input type="text" id="things"  name="donation[]"></td></tr>';
                                        }
                                    }
                                ?>
                                <tr><td id="promise_td">Note</td><td><textarea col=30 rows=4 id="promise_td" name="note"></textarea></td></tr>
                                <tr><td ><input id=promise_but type='submit' name=pro_submit_button value="PROMISE" ></td></tr>
                            </table>    
                        </div> 
                    <?php } ?>
                </form>   
            </div>      


    </body>
</html>
