<?php
require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require_once $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

$sql=$_POST['sql'];
$result=$con->query($sql);

$type=$_POST['type'];
$person=$_POST['person'];
$id_n=$_POST['id_n'];

//echo $sql;
//echo $type.$person.$id_n;

if ($type==1){
    $status=$_POST['status'];
    $event=$_POST['event'];
    
    $to=$id_n;
    $link='/event/view_promises_on_me.php?event_id='.$event;
    $sql="SELECT name FROM `disaster_events` WHERE event_id=".$event;
    $event_name=$con->query($sql)->fetch_assoc()['name'];
    if($status=='pending'){
        $mssg=$person." claimed that he or she helped you for ".$event_name ;
    }else{
        $mssg=$person." withdrew his or her claim for ".$event_name ;
    }
}elseif ($type==2){    
    $name=$_POST['name'];
    $event=$_POST['event'];
    if( strlen($id_n) < 9){
        $sql="SELECT NIC_num FROM `org_members` WHERE org_id=".$id_n;
        $result=$con->query($sql)->fetch_all();
        $to=implode(",",array_column($result,0));
        $you=$name;
        $link="/organization/event/view_our_promises.php?org_id=".$id_n."&event_id=".$event;
    }else{
        $to=$id_n;
        $you='you';
        $link='/event/view_my_individual_promises.php?event_id='.$event;
    }
    $mssg=$person." said that ".$you." helped him or her" ;
    
}elseif ($type==3){
    $status=$_POST['status'];
    $fund=$_POST['fund'];
    $fun_id=$_POST['fun_id'];
    $to=$id_n;
    $link='/fundraising/view_fundraising.php?view_fun='.$fun_id;
    if($status=='pending'){
        $mssg=$person." claimed that he or she helped your ".$fund ;
    }else{
        $mssg=$person." withdrew his or her claim of ".$fund ;
    }
    
}elseif ($type==4){
    $fund=$_POST['fund'];
    $to=$id_n;
    $link='/fundraising/view_my_promises.php?';
    $mssg=$person." said that you helped for ".$fund ;
    
}elseif ($type==5){
    $event=$_POST['event'];
    $org=$_POST['org'];
    $status=$_POST['status'];
    $event_id=$_POST['event_id'];
    $to=$id_n;
    $link='/event/view_promises_on_me.php?event_id='.$event_id;
    if($status=='pending'){
        $mssg=$org." claimed that they helped you for ".$event ;
    }else{
        $mssg=$org." withdrew their claim for ".$event ;
    }
    
}
//  echo $to;
//  echo $mssg;
//  echo $link;

require $_SERVER['DOCUMENT_ROOT']."/notification/notification_sender.php";
$sender = new Notification_sender($to,$mssg,$link,true);
$sender->send();

?>