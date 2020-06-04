<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['events'])){
        $query = 'select event_id, name from disaster_events';
        $result = $con->query($query);
        if($result){
            while($raw = $result->fetch_assoc()){
                echo '</br><button class=view_events_list onclick=view_event('.$raw['event_id'].')>'.$raw['name'].'</button>';
            }
        }
    }
?>