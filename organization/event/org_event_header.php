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
            <div id='marka_area_btn_container'>
                <a class=a_button href="/organization/event/mark_area/?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>">Mark Area</a>
            </div>
            <div id='mark_place_btn_container'>
                <a class=a_button href="/organization/event/mark_place/?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>">Mark Place</a>
            </div>
        </div>