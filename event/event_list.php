<?php  
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    $query="select event_id,name,status from disaster_events order by event_id desc";
    $result=$con->query($query);
?>
<div id='event_overlay' onclick='remove(this)'></div>
<div class='events_php_container'>
    <form action='/event' method='get'>
        <table id=event_table>
            <?php
                echo "<tr ><td class=name><a href='/event/all_events.php'><button type=button class='event_name' name=event_id>View all</button></a></td></tr>";
                while($row=$result->fetch_assoc()){
                    echo "<tr><td class=name><button type=submit class='event_name ". $row['status'] ."_event' name=event_id value=" . $row['event_id'] . ">" . $row['name'] . "</button></td></tr>";
                }
            ?>
        </table>
    </form>
</div>