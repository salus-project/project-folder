<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $event_id=$_POST['event_id'];
        $to=$_POST['to'];
        $item=$_POST['item'];
        $amount=$_POST["amount"];
        $update_id=$_POST['update_id'];
        $by=$_POST['by'];
        $note=$_POST['note']?:'';
        $del_detail = array_filter(explode(',', $_POST['del']));

        $pri_query = '';

        foreach( $del_detail as $row_del){
            $pri_query.= "delete from event_".$event_id."_pro_don where id=$row_del;";
        }

        for($x=0 ; $x < count($item) ; $x++){
            if(!empty($item[$x])){
                if($by=='your_self'){
                    $by_person=$_SESSION['user_nic'];
                    $by_org='NULL';
                }else{
                    $by_person='';
                    $by_org=$by;
                }
                if(empty($amount[$x])){
                        $amount[$x]=0;
                    }
                if($update_id[$x]=='0'){
                    $pri_query .= "INSERT INTO event_".$event_id."_pro_don (pro_don, by_org, by_person, to_person, item, amount, note) VALUES ('promise', $by_org, '$by_person', '$to', '$item[$x]', '$amount[$x]', '$note');";
                }else{
                    $pri_query .= "UPDATE `event_".$event_id."_pro_don` SET item='$item[$x]', amount = $amount[$x], note='$note' where id=$update_id[$x];";
                }
            }
        }
        if(mysqli_multi_query($con, $pri_query)){
            header('location:/event?event_id='.$event_id);
        }else{
            header("location:/event/help?event_id=".$event_id."&by=".$by."&to=".$to);
        }
    }