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
<link rel="stylesheet" href="/css_codes/publ.css">
<script src="/govpost/govpost.js"></script>
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
                    echo "<tr><td class='view_event_td'>" . ucfirst('Status') . "</td><td id=column2>" . ucfirst($result['status']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Deaths and damages') . "</td><td id=column2>" . ucfirst($result['detail']) . "</td></tr>";
                    echo "<tr><td class='view_event_td'>" . ucfirst('Unsafe people') . "</td><td id=column2>" . ucfirst($result['affected_no']) . "</td></tr>";
                ?>
            </table>
        </div>
    </div>
    <div id=pictures>
        <div class='head'>Photos</div>
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
                        echo         "<a class='person_a' href='/event/volunteer.php?event_id=".$_GET['event_id']."&nic=".$nic_num."'>".$full_name."</a>";
                        echo    "</td>";
                        echo "</tr>";
                    
                }
            ?>
            </table>
        </div>
    </div>
    <div id=organizations>
        <div class='head' colspan=2>
            Active Organizations
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
    <div class='head' style='width:550px;margin:auto;box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>
        Goverment posts and announcements
    </div>
    <div id="content">
    </div>
    <script>
        var post = new GovPost('<?php echo $_SESSION['user_nic'] ?>', <?php echo $_GET['event_id'] ?>);
        post.get_post();
    </script>
</div>

<script type="text/javascript" src="/js/slide_show.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>