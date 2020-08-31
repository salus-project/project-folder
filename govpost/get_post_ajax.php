<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    if(isset($_POST['offset'])){
        $condition = '';
        if(isset($_POST['event'])){
            $condition = ' where event='.$_POST['event'].' ';
        }
        $query='select g.*, e.name as event_name from goveposts as g left join disaster_events as e on g.event = e.event_id '.$condition.' order by g.post_index desc limit '.$_POST['offset'].', 5;';
        $result=$con->query($query);
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    }
?>