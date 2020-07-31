<?php  
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
?>
<div id='map_container'>
    <?php require $_SERVER['DOCUMENT_ROOT']."/common/map/map.html"; ?>
</div>
<div id=event_body>
    <div id='table_caontainer'>
        <table id=view_event_table>
            <thead>
                <th class='head' colspan=2>
                    Event Detail
                </th>
            </thead>
            <?php
                echo "<tr><td class='view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Affected districts') . "</td><td id=column2>" . ucfirst($result['affected_districts']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Start date') . "</td><td id=column2>" . ucfirst($result['start_date']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('End date') . "</td><td id=column2>" . ucfirst($result['end_date']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Status') . "</td><td id=column2>" . ucfirst($result['status']) . "</td></tr>";
                echo "<tr><td class='view_event_td'>" . ucfirst('Deaths and damages') . "</td><td id=column2>" . ucfirst($result['detail']) . "</td></tr>";
            ?>
        </table>
    </div>
    <div id=pictures>
        <h3>Photos</h3>
    </div>  
</div>

<div id=social_events>
    <div id=help_requested>
        <table id=view_event_table>
        <thead>
            <th class='head' colspan=2>
                Help requested people
            </th>
        </thead>
        <?php
            foreach($help_requested as $row_req){
                $nic_num=$row_req["NIC_num"];
                    $full_name=$row_req["first_name"].' '.$row_req["last_name"];
                    echo "<tr>";
                    echo    "<td class='view_event_td'>";
                    echo         "<a class='person_a' href='/event/requester.php?event_id=".$_GET['event_id']."&nic=".$nic_num."'>".$full_name."</a>";
                    echo    "</td>";
                    echo "</tr>";
                
            }
        ?>
        </table>
    </div>
    <div id=affected>
        <table id=view_event_table>
        <thead>
            <th class='head' colspan=2>
                Volunteers detail
            </th>
        </thead>
        <?php
            foreach($volunteers as $row_req){
                $nic_num=$row_req["NIC_num"];
                    $full_name=$row_req["first_name"].' '.$row_req["last_name"];
                    echo "<tr>";
                    echo    "<td class='view_event_td'>";
                    echo                "<a class='person_a' href='/event/volunteer.php?event_id=".$_GET['event_id']."&nic=".$nic_num."'>".$full_name."</a>";
                    echo    "</td>";
                    echo "</tr>";
                
            }
        ?>
        </table>
    </div>
    <div id=organizations>
        <table id=view_event_table>
            <thead>
                <th class='head' colspan=2>
                    Volunteers detail
                </th>
            </thead>
                <?php
                foreach($orgs as $row){
                    echo "<tr>";
                    echo    "<td class='view_event_td'>";         
                        echo "<a class='person_a' href=''>".$row['org_name']."</a>";
                    echo    "</td>";
                    echo "</tr>";
                }
                ?>
        </table>
    </div>
</div>
<div id=news_field>
    Goverment posts and announcements about this event
</div>
<div class='div1 popup' id='popup_div'>
</div>
<div id='overlay'>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>