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
            $query1='select NIC_num,first_name,last_name from civilian_detail';
            $result1=$con->query($query1);
            if(!$result1){
                echo mysqli_error($con);
            }
            while($civilian=$result1->fetch_assoc()){
                $nic_num=$civilian["NIC_num"];
                $help_request_status= explode(" ",$result['user_'.$nic_num])[1];
                if ($help_request_status=='requested') {
                    $full_name=$civilian["first_name"].' '.$civilian["last_name"];
                    echo "<tr>";
                    echo    "<td id=data>";
                    echo            "<input type=hidden name='to' value=".$civilian['NIC_num'].">";
                    echo            "<div class='requested' onclick='help_option(this)'>";
                    echo                $full_name;
                    echo            "</div>";
                    echo    "</td>";
                    echo "</tr>";
                }
            }
        ?>
        </table>
    </div>
    <div id=affected>
        <h2>Affected people detail</h2>
    </div>
    <div id=organizations>
        <h2>Organizations on action</h2>
    </div>
</div>
<div class='div1 popup' id='popup_div'>
</div>
<div id='overlay'>
</div>

<script>
    var safe_status = '<?php echo $status[0]?>';
    var help_status = '<?php echo $status[1]?>';
    var volunteer_status = '<?php echo $status[2]?>';

    var event_id='<?php echo $result['event_id'] ?>';
    var nic_num = '<?php echo $_SESSION['user_nic']?>';
    var organization = <?php echo $js_organization ?>;
    var district_in_nic = '<?php echo $_SESSION['district'] ?>';
</script>

<script src='/js/view_event.js'></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>