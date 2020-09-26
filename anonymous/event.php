<?php  
    require $_SERVER['DOCUMENT_ROOT']."/anonymous/ano_header.php";
    //require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<title>Event</title>
<link href="/common/map/vector_editor.css?t=1593079387" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="/common/map/map.js"></script>
<link rel="stylesheet" href="/css_codes/view_event.css">
<link rel="stylesheet" href="/css_codes/style.css">
<link href="/css_codes/slideshow.css" rel="stylesheet">

<script>
    btnPress(4);
</script>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'].";
            select * from event_".$_GET['event_id']."_locations;";
                    
            if(mysqli_multi_query($con, $query)){
                $sql_result = mysqli_store_result($con);
                $result = mysqli_fetch_assoc($sql_result);
                mysqli_free_result($sql_result);
                $imgs = array_filter(explode(',', $result['img']));
                mysqli_next_result($con);
                if($sql_result = mysqli_store_result($con)){
                    $location_arr = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
                    mysqli_free_result($sql_result);
                }else{
                    $location = [];
                }
            }
        ?>
        <script>
            var event_name = '<?php echo $result['name'] ?>';
            var areaGeoJson = JSON.parse('<?php echo $result['geoJson'] ?>');
            var location_arr = <?php echo json_encode($location_arr) ?>;
        </script>
        
        <div id=closed_event_header>
            <div id=title_box>
                <div class=event_header_name_profile>
                    <div class="event_header_profile">
                        <img src="/common/documents/Event/<?php echo $result['event_id'] ?>.jpg" alt="Opps..." class="fund_pic">
                    </div>
                    <div class=event_header_name>
                        <?php echo $result['name'] ?>
                    </div>
                </div>
             </div>
        </div>

        <div id='map_container'>
    <div id='map'></div>
</div>
<style>
    #map{
        margin:auto;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
</style>
<script>
    var myGeo = new EventGeo('map_container');
    myGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

    for(var place of location_arr){
        create_place(place);
    }
</script>
        <div id=event_body>
            <div id='ano_table_caontainer'>
                <div class='head' colspan=2>
                    Event Detail
                </div>
            <div class='event_con'>
                <table id=view_event_table>           
                <?php
                    echo "<tr><td class='view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Affected districts') . "</td><td id=column2>" . ucfirst($result['affected_districts']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Start date') . "</td><td id=column2>" . ucfirst($result['start_date']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('End date') . "</td><td id=column2>" . ucfirst($result['end_date']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Status') . "</td><td id=column2>" . ucfirst($result['status']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Deaths and damages') . "</td><td id=column2>" . ucfirst($result['detail']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Unsafe people') . "</td><td id=column2>" . ucfirst($result['affected_no']) . "</td></tr>";
               ?>
                </table>
            </div>
        </div>
        <div id=pictures>
        <h3 class='head'>Photos</h3>
        <?php	
        if(count($imgs)>0){
            echo '<div class="slideshow-container">';

            foreach ($imgs as $img) {?>
                    <div class="mySlides fade">
                        <img class='slide_show_img' src="/common/documents/Event/secondary/<?php echo $img ?>.jpg" style="width:100%">
                    </div>
        <?php }
            echo '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>';
        
            ?>
            
            <br/>
            <div style='text-align: center;position: absolute;bottom: 5px;left: 350px;'>
            <?php
                for($x=0 ; $x<count($imgs) ; $x++) {?>
                <span class="dot"></span> 
            <?php }
            
            echo '</div>';
        }else{
            echo '<div style="width:100%; height:341px;">
                <img style="width:100%;" src="/common/documents/Covers/default.jpg">
            </div>';
        }
        ?>
        </div>
</div>
<div id=news_field>
    Goverment posts and announcements about this event
</div>

<div id='overlay'>
</div>
<script type="text/javascript" src="/js/slide_show.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>