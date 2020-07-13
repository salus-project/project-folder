<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['safe_status'])){
        $status_query = "select user_" . $_SESSION['user_nic'] . " from disaster_events where event_id = '" . $_POST['event_id']."'";
        $result = ($con->query($status_query))->fetch_assoc();
        $status = explode(" ",$result['user_'.$_SESSION['user_nic']]);
        $status[0] = $_POST['safe_status'];
        $update_str = join(" ",$status);
        $update_query = "UPDATE disaster_events SET user_".$_SESSION['user_nic']." = '".$update_str."' where event_id = '".$_POST['event_id'] . "'";
        $update = $con->query($update_query);
        if($update){
            echo 'true';
        }else{
            echo 'false';
        }
    }
?>