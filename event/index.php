<?php require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
$id=$result['event_id'];
$imgs = array_filter(explode(',', $result['img']));
?>
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
<link href="/css_codes/slideshow.css" rel="stylesheet">
<div id=event_body>
    <div id='table_caontainer'>
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
                        <img class='slide_show_img' src="http://d-c-a.000webhostapp.com/Event/secondary/<?php echo $img ?>.jpg" style="width:100%">
                    </div>
        <?php }
            echo '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>';
        
            ?>
            
            <br/>
            <div style='text-align: center;'>
            <?php
                for($x=0 ; $x<count($imgs) ; $x++) {?>
                <span class="dot"></span> 
            <?php }
            
            echo '</div>';
        }else{
            echo '<div style="width:100%; height:341px;">
                <img style="width:100%;" src="http://d-c-a.000webhostapp.com/Covers/default.jpg">
            </div>';
        }
        ?>
    </div>  
</div>

<div id=social_events>
    <div id=help_requested>
        <div class='head' colspan=2>
                Help requested people
        </div>
        <div class='table_con'>
            <table id=view_event_table>     
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
    </div>
    <div id=affected>
        <div class='head' colspan=2>
                Volunteers detail
        </div>
        <div class='table_con'>
            <table id=view_event_table>
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
    </div>
    <div id=organizations>
        <div class='head' colspan=2>
            Organizations on action
        </div>
        <div class='table_con'>
            <table id=view_event_table>
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
</div>
<div id=news_field>
    Goverment posts and announcements about this event
</div>
<div class='popup_div popup' id='popup_div'>
</div>
<div id='overlay'>
</div>
<script type="text/javascript" src="/js/slide_show.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>