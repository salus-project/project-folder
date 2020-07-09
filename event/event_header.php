<?php  
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Event</title>
        <link rel="stylesheet" href="/css_codes/view_event.css">
        <link rel="stylesheet" href="/css_codes/style.css">
        <link rel="stylesheet" href="/css_codes/help_request_popup.css">
        <script type="text/javascript" src="/js/request_help_popup.js"></script>
        <script type="text/javascript" src="/js/volunteer_application.js"></script>
    </head>
    <body>

        <script>
            btnPress(4);
        </script>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'].";
                    select * from event_".$_GET['event_id']."_locations;
                    select * from organizations where leader = '" . $_SESSION['user_nic'] . "' OR co_leader = '" . $_SESSION['user_nic'] . "';
                    select * from event_".$_GET['event_id']."_help_requested;";
            $result;
            if(mysqli_multi_query($con, $query)){
                $sql_result = mysqli_store_result($con);
                $result = mysqli_fetch_assoc($sql_result);
                mysqli_free_result($sql_result);
            }
            
            $status=explode(" ",$result['user_'.$_SESSION['user_nic']]);
            mysqli_next_result($con);
            $sql_result = mysqli_store_result($con);
            $location_arr = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
            mysqli_free_result($sql_result);

            mysqli_next_result($con);
            $sql_result = mysqli_store_result($con);
            $organization=array();

            while($org=$sql_result->fetch_assoc()){
                array_push($organization,$org);
            }
            mysqli_free_result($sql_result);
            $js_organization = json_encode($organization);

            mysqli_next_result($con);
            $sql_result = mysqli_store_result($con);
            $help_requested = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
            mysqli_free_result($sql_result);
        ?>
        <script>
            var event_name = '<?php echo $result['name'] ?>';
            var areaGeoJson = JSON.parse('<?php echo $result['geoJson'] ?>');
            var location_arr = <?php echo json_encode($location_arr) ?>;
            console.log(location_arr);
        </script>
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
                <div class='other_menu_container'>
                    <a href="view_my_individual_promises.php?event_id=<?php echo $_GET['event_id']?>" id="indi_prom_btn" class='other_menus'>
                        My Promises
                    </a>
                    <a href="/event/mark_area?event_id=<?php echo $_GET['event_id']?>" id="mark_area" class='other_menus'>
                        Suggest an Area
                    </a>
                </div>
                <div id=status>
                    <div id=safe_btn>

                    </div>

                    <div id=help_btn>
                    </div>
                    
                    <div id=volunteer_btn>
                    </div>
                    
                    
                </div>
            </div>
        </div>