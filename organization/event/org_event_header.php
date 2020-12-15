<?php 
    require $_SERVER['DOCUMENT_ROOT']."/organization/view_org_header.php" ;
    if($text_role  == 'visitor' || $text_role  == 'member'){
        echo 'Access Denied';
        // header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/organization/visitor_event/?event_id=".$_GET['event_id']."&selected_org=".$org_id));
        // ob_end_flush();
        // ob_flush();
        // flush();
    }
?>
<head>
    <title>Organization Events</title>
    <link rel="stylesheet" href='/css_codes/org_view_event.css'>
</head>
        
<div id='org_body'>
    
    
</div>
<?php
    $query="select * from disaster_events where event_id =" . $_GET['event_id'].";
            select * from event_".$_GET['event_id']."_locations;";
    $result;
    if(mysqli_multi_query($con, $query)){
        $sql_result = mysqli_store_result($con);
        $result = mysqli_fetch_assoc($sql_result);
        mysqli_free_result($sql_result);
    }
    if(!isset($result['status']) || $result['status']=='closed'){
        header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/organization/visitor_event/?event_id=".$_GET['event_id']."&selected_org=".$org_id));
        ob_end_flush();
        ob_flush();
        flush();
    }
    
    mysqli_next_result($con);
    $sql_result = mysqli_store_result($con);
    $location_arr = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
    mysqli_free_result($sql_result);
    
    $event_name=$result['name'];
?>
<script>
    var event_name = '<?php echo $result['name'] ?>';
    var areaGeoJson = JSON.parse('<?php echo $result['geoJson'] ?>');
    var location_arr = <?php echo json_encode($location_arr) ?>;
</script>
<div id=event_header>
    <div id=title_box>
        <?php echo $result['name'] ?>
    </div>
    <div id='promise_btn_container'>
        <a class=a_button href="/organization/event/view_our_promises.php?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>">Our Promises</a>
    </div>
    <div class="org_event_area_select_div"  >
        <select  id="select_type" class="org_event_area_select" name="select_type" onchange="location = this.value;">
            <option selected disabled hidden class="org_event_select_first" value="0">Areas</option>
            <option class="org_event_area_select_opt" value="/organization/event/mark_area/?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>" >
                <div id='marka_area_btn_container'>
                    <a class=a_button >Mark Area</a>
                </div>
            </option>
            <option class="org_event_area_select_opt" value="/organization/event/mark_place/?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>">
                <div id='mark_place_btn_container'>
                    <a class=a_button >Mark Place</a>
                </div>
            </option>
            <option class="org_event_select_marked org_event_area_select_opt"  value="/organization/event/org_marked_area_place.php?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>">
                <div id="marked_area_btn_container">
                    <a >Marked Area</a>
                </div>
            </option>
        </select>
    </div>
</div>
