<?php  
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
    $query="select event_id,name,status from disaster_events";
    $result=$con->query($query);
?>

<title>Events</title>
<link rel="stylesheet" href="/staff/css_codes/events.css">
    
<script>
    btnPress(3);
</script>

<div id=body>
    <div>
        <form action='/staff/event/view_event.php' method='get'>
            <div class="event_detail">
                <table class="event_table">
                    <tr>
                        <th colspan="2">
                            <a class="tag" href="/staff/event/create_event.php">
                                <i class="fa fa-calendar" aria-hidden="true" style="font-size:20px;color:#6b7c93;">  Create new event</i>
                            </a>
                        </th>
                    </tr>
                    <tr>
                        <th> Event name</th>
                        <th> Status</th>
                    </tr>
                    <?php
                        while($row=$result->fetch_assoc()){
                            echo "<tr><td><div class='event_img'><img src='/common/documents/Event/resized/".$row['event_id'].".jpg'/></div>" . $row['name'] . "<button type=submit class=event_name name=event_id value=". $row['event_id'] ."></button></td><td>" . $row['status'] . "</td></tr>";
                        }
                    ?>
                </table>
            </div>
        </form>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>