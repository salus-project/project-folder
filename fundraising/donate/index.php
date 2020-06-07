<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $id=$_GET['id'];
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
        <div class="form_div">
            <form method="POST" action=<?php echo "index_php.php";?>>  
                <input type="hidden" name="id" value= <?php echo $id;?>>        
                <div id="title">
                    <center><b><?php echo $result['name'] ?></b></center>
                </div> 
                <div class="table_div">
                    <table class="donate_tab">
                        <?php                       
                            $idd= filter($result['by_civilian']);
                            $query3="select * from civilian_detail where NIC_num='$idd' ";
                            $result3=($con->query($query3))->fetch_assoc();
                            echo '<tr><td id=column1> Created by </td><td id=column2>' . $result3['first_name'] ." ". $result3['last_name']. '</td></tr>';                              
                            
                            if($result['by_org']!=NULL){
                                $query1="select * from organizations where org_id=". $result['by_org'];
                                $result1=($con->query($query1))->fetch_assoc();
                                echo '<tr><td id=column1> Org name</td><td id=column2>' . $result1['org_name'] . '</td></tr>';
                            }
                            if($result['for_event']==NULL){
                                echo '<tr><td id=column1> Purpose</td><td id=column2>' . $result['for_any'] . '</td></tr>';
                            }else{
                                $query2="select * from disaster_events where event_id=". $result['for_event'];
                                $result2=($con->query($query2))->fetch_assoc();
                                echo '<tr><td id=column1>Purpose</td><td id=column2>' . $result2['name'] . '</td></tr>';
                            }
                            
                            echo '<tr><td id=column1> Request</td><td id=column2>' . $result['type'] . '</td></tr>';
                            
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
                <div class="table_div"> 
                    <table class="donate_tab">
                        <?php
                            if($result['type']=="money only"){
                                echo '<tr><td id="promise_td"> Amount in rs</td><td id="promise_td"><input type="text" id="money" name="donation[]"></td></tr>';
                            }elseif($result['type']=="things only"){
                                $query="select * from fundraisings where id=".$id;
                                $result=($con->query($query))->fetch_assoc();
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
                        <tr><td ><input id=promise_but type='submit' name=promise_but value="PROMISE" ></td></tr>
                    </table>    
                </div> 
            </form>   
        </div>      
    </body>
</html>
