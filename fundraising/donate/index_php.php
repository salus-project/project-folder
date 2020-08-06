<?php
    ob_start();
    ignore_user_abort();

    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $by_person=$_SESSION['user_nic'];
    $for_fund=$_POST['for_fund']?:'NULL';

    if(isset($_POST['pro_cancel_button'])){
        $query="DELETE from fundraising_pro_don_content WHERE don_id=(select id from fundraising_pro_don WHERE by_person='".$by_person."' and for_fund='".$for_fund."');
        DELETE from fundraising_pro_don WHERE by_person='".$by_person."' and for_fund='".$for_fund."';";
        $msg=" cancel his promise for ";
    }else{
        $item = array_filter($_POST['item']);
        $amount = $_POST['amount'];
        $update_id=$_POST['update_id'];
        $mark=$_POST['mark'];
        $note=filt_inp($_POST['note'])?:'';
        
        $query='';

        if($_POST['entry_update_id']!=0){
            $msg=" edit his promise for ";
            $del_detail = array_filter(explode(',', $_POST['del']));

            $query = '';
            foreach( $del_detail as $row_del){
                $query.= "delete from fundraising_pro_don_content where id=".$row_del.";";
            }
            $query.="update fundraising_pro_don set note='".$note."' where id={$_POST['entry_update_id']};";
            for($x=0 ; $x < count($item) ; $x++){
                if(!empty($item[$x])){
                    $item1=filt_inp(ready_input($item[$x]));
                    $amout1=filt_inp($amount[$x]);
                    if(empty($amount[$x])){
                            $amout1=0;
                    }
                    if($update_id[$x]=='0'){
                        $query .= "INSERT INTO fundraising_pro_don_content (don_id, item, amount, pro_don) VALUES ({$_POST['entry_update_id']}, '".$item1."', '".$amout1."', '{$mark[$x]}');";
                    }else{
                        $query .= "UPDATE `fundraising_pro_don_content` SET item='".$item1."', amount = '".$amout1."', pro_don='{$mark[$x]}' where id=$update_id[$x];";
                    }
                }
            }
        }else{

            $query = "insert into fundraising_pro_don (by_person, for_fund, note) values ('$by_person',$for_fund,'".$note."');";
            $msg=" prmised to donate for ";
            if(count($item)>0){                
                $querry_arr = array();
                for($x=0; $x < count($item); $x++ ){
                    $item1=filt_inp(ready_input($item[$x]));
                    $row_amount = filt_inp($amount[$x])?:'0';
                    array_push($querry_arr, "(last_insert_id(),'".$item1."','$row_amount','$mark[$x]')");
                }
                $query.= "INSERT INTO `fundraising_pro_don_content`(`don_id`, `item`, `amount`, `pro_don`) VALUES ". implode(", ", $querry_arr).";";
            }
            
        }
    }

    //echo $query;
    $sql="SELECT name,by_civilian FROM `fundraisings` where id=".$for_fund.";";
    if(mysqli_multi_query($con,$sql.$query)){
        $size = ob_get_length();
        header("Content-Encoding: none");
        header("Content-Length: {$size}");
        header("location:".$_SERVER['HTTP_REFERER']);
        header("Connection: close");

        header('location:'.$_SERVER['HTTP_REFERER']);

        ob_end_flush();
        ob_flush();
        flush();

        $sql_res=mysqli_store_result($con);
		$res=$sql_res->fetch_assoc();
		mysqli_free_result($sql_res);
        
        $name= $_SESSION['first_name']." ".$_SESSION['last_name'];
        $to=$res['by_civilian'];
        $mssg= $name.$msg.$res['name'];
        $link="/fundraising/view_fundraising.php?view_fun=".$for_fund;

        echo $to."<br>".$mssg."<br>".$link;
        require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
        $sender = new Notification_sender($to,$mssg,$link,true);
        $sender->send();
    }else{
        //header("location:/event/help?event_id=".$event_id."&by=".$by."&to=".$to);
        echo "<br>Not Success";
    }
}
?>