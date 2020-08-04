<?php  
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Event</title>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

        <link href="/common/map/vector_editor.css?t=1593079387" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
        <script src="/common/map/map.js"></script>
        
        <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
        <link rel="stylesheet" href="/css_codes/view_event.css">
        <link rel="stylesheet" href="/css_codes/style.css">
        <link rel="stylesheet" href="/css_codes/help_request_popup.css">
        <script type="text/javascript" src="/js/request_help_popup.js"></script>
        <script type="text/javascript" src="/js/volunteer_application.js"></script>
        <script defer src='/js/view_event.js'></script>
    </head>
    <body>

        <script>
            btnPress(4);
        </script>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'].";
                    select * from event_".$_GET['event_id']."_locations;
                    select * from organizations;
                    SELECT `event_".$_GET['event_id']."_help_requested`.*, civilian_detail.first_name,civilian_detail.last_name from event_".$_GET['event_id']."_help_requested INNER JOIN civilian_detail on event_".$_GET['event_id']."_help_requested.NIC_num=civilian_detail.NIC_num;
                    SELECT `event_".$_GET['event_id']."_volunteers`.*, civilian_detail.first_name,civilian_detail.last_name from event_".$_GET['event_id']."_volunteers INNER JOIN civilian_detail on event_".$_GET['event_id']."_volunteers.NIC_num=civilian_detail.NIC_num;
                    select org_name,org_id from organizations;";    
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

            mysqli_next_result($con);
            $sql_result = mysqli_store_result($con);
            $volunteers = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
            mysqli_free_result($sql_result);

            mysqli_next_result($con);
            $sql_result = mysqli_store_result($con);
            $orgs = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
            mysqli_free_result($sql_result);
        
        ?>
        <script>
            var event_name = '<?php echo $result['name'] ?>';
            var areaGeoJson = JSON.parse('<?php echo $result['geoJson'] ?>');
            var location_arr = <?php echo json_encode($location_arr) ?>;
        </script>
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
                <div class='other_menu_container'>
                    <a href="view_my_individual_promises.php?event_id=<?php echo $_GET['event_id']?>" id="indi_prom_btn" class='other_menus'>
                        My Promises
                    </a>
                    <a href="view_promises_on_me.php?event_id=<?php echo $_GET['event_id']?>" id="pro_on_me_btn" class='other_menus'>
                        Promises on me
                    </a>
                    <a href="/event/mark_area?event_id=<?php echo $_GET['event_id']?>" id="mark_area" class='other_menus'>
                        Suggest an Area
                    </a>
                    <a href="/event/suggested_area_mine.php?event_id=<?php echo $_GET['event_id']?>" id="suggested_area_mine" class='other_menus'>
                        My suggestens
                    </a>
                    <a href="/event/suggested_area_all.php?event_id=<?php echo $_GET['event_id']?>" id="suggested_area_all" class='other_menus'>
                        Suggested areas
                    </a>
                </div>
                <div id=status>
                    <div id=safe_btn_container>
                    </div>

                    <div id=help_btn>
                    </div>
                    
                    <div id=volunteer_btn>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <script>
            var safe_status = '<?php echo $status[0]?>';
            var help_status = '<?php echo $status[1]?>';
            var volunteer_status = '<?php echo $status[2]?>';

            var event_id='<?php echo $result['event_id'] ?>';
            var nic_num = '<?php echo $_SESSION['user_nic']?>';
            var organization = <?php echo $js_organization ?>;
            var district_in_nic = '<?php echo isset($_SESSION['district'])?$_SESSION['district']:'' ?>';
        </script>