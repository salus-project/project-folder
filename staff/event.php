<?php  
    session_start();
    require 'dbconfi/confi.php';
    require "header.php";
    $query="select event_id,name,status from disaster_events";
    $result=$con->query($query);
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Events</title>
        <link rel="stylesheet" href="css_codes/events.css">
    </head>

    <body>
        <div id=body>
            <div>
                <div class="new_event"> <a class="tag" href="create_event.php"><i class="fa fa-calendar" aria-hidden="true" style="font-size:25px;color:black;">  Create new event</i></a></div>
            </div>
            <div>
                <form action='view_event.php' method='get'>
                <div class="event_detail">
                    <table class="event_table">
                        <tr>
                            <th> Event name</th>
                            <th> Status</th>
                        </tr>
                        <?php
                            while($row=$result->fetch_assoc()){
                                echo "<tr><td><button type=submit class=event_name name=event_id value=". $row['event_id'] .">" . $row['name'] . "</button></td><td>" . $row['status'] . "</td></tr>";
                            }
                        ?>
                    </table>
                <div>
                </form>
            </div>
        </div>

    </body>
</html>