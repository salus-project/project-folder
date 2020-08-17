<?php  
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $query="select event_id,name,status from disaster_events order by event_id desc";
    $result=$con->query($query);
?>
<div id='event_overlay' onclick='remove(this)'></div>
<div class='events_php_container'>
    <div class='event_table_con'>
    <form action='/anonymous/event.php' method='get'>
        <table id=event_header_table>
            <?php
                echo "<div class=view_all>EVENTS</div><button class='event_setting_btn' type=button><i class='fa fa-cog'  aria-hidden='true'></i></button>";
                echo "<div class='hidden_event_div'><a href='/anonymous/all_event.php'><button type=button class='event_name view_all_btn' name=event_id>View all</button></a></div>";
                while($row=$result->fetch_assoc()){
                    echo "<tr><td class=name ><button type=submit class='event_name ". $row['status'] ."_event' name=event_id value=" . $row['event_id'] . ">" . $row['name'] . "</button></td></tr>";
                }
            ?>
        </table>
    </form>
    </div>
</div>
