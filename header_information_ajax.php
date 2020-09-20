<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    session_start();
    $noti = NotificationDb::getConnection();
    if(isset($_GET['header'])){
        $output=[];
        $query="select count(Notification_id) from user_notif_ic_".$_SESSION['user_nic']." where status='unseen';
                select count(id) from user_message_".$_SESSION['user_nic']." where (status=0 and isnull(_to));";
        $noti->multi_query($query);
        $result=$noti->store_result();
        $output['notification']=$result->fetch_row()[0];
        $result->free_result();
        $noti->next_result();
        $result=$noti->store_result();
        $output['message']=$result->fetch_row()[0];
        $result->free_result();

        echo json_encode($output);
    }
?>