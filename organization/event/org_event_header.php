<!DOCTYPE html>
<html>
    <head>
        <title>Events</title>
        <link rel="stylesheet" href='/css_codes/org_view_event.css'>
    </head>
    <body>
        <?php require $_SERVER['DOCUMENT_ROOT']."/organization/view_org_header.php" ?>
        
        <div id='org_body'>
            
            
        </div>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'];
            $result=($con->query($query))->fetch_assoc();
        ?>
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
            </div>
            <div id='promise_btn_container'>
                <a class=a_button href="/organization/event/view_our_promises.php?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>">Our Promises</a>
            </div>
            <div class="org_event_area_select_div"  >
                <select  id="select_type" class="org_event_area_select" name="select_type" onchange="location = this.value;">
                    <option selected disabled hidden class="org_event_select_first" value="0">Select option:</option>
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