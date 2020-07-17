<?php  
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
?>
<div id='map_container'>
    <?php require $_SERVER['DOCUMENT_ROOT']."/event/map.html"; ?>
</div>
<div id=detail_body>
    <div id='table_caontainer'>
        <table id=table>
            <thead>
                <th colspan=2>
                    Event Detail
                </th>
            </thead>
            <?php
                echo "<tr><td class='view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Affected districts') . "</td><td id=column2>" . ucfirst($result['affected_districts']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Start date') . "</td><td id=column2>" . ucfirst($result['start_date']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('End date') . "</td><td id=column2>" . ucfirst($result['end_date']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Status') . "</td><td id=column2>" . ucfirst($result['status']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Deaths and damages') . "</td><td id=column2>" . ucfirst($result['detail']) . "</td></tr>";
            ?>
        </table>
    </div>
    <div id=news_field>
        Goverment posts and announcements about this event
    </div>
    
    
</div>
<div id=pictures>
    <h3>Photos</h3>
</div>
<div id=social_events>
    <div id=help_requested>
        <h2>Help requested people<h2>
        <table>
        <?php
            foreach($help_requested as $row_req){
                $nic_num=$row_req["NIC_num"];
                    $full_name=$row_req["first_name"].' '.$row_req["last_name"];
                    echo "<tr>";
                    echo    "<td id=data>";
                    echo                "<a href='/event/requester.php?event_id=".$_GET['event_id']."&nic=".$nic_num."'>".$full_name."</a>";
                    echo    "</td>";
                    echo "</tr>";
                
            }
        ?>
        </table>
    </div>
    <div id=affected>
        <h2>Volunteers detail</h2>
        <table>
        <?php
            foreach($volunteers as $row_req){
                $nic_num=$row_req["NIC_num"];
                    $full_name=$row_req["first_name"].' '.$row_req["last_name"];
                    echo "<tr>";
                    echo    "<td id=data>";
                    echo                "<a href='/event/volunteer.php?event_id=".$_GET['event_id']."&nic=".$nic_num."'>".$full_name."</a>";
                    echo    "</td>";
                    echo "</tr>";
                
            }
        ?>
        </table>
    </div>
    <div id=organizations>
        <h2>Organizations on action</h2>
    </div>
</div>
<div class='div1 popup' id='popup_div'>
</div>
<div id='overlay'>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>