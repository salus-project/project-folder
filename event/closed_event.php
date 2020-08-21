<script>
    var event_name = '<?php echo $result['name'] ?>';
    var areaGeoJson = JSON.parse('<?php echo $result['geoJson'] ?>');
</script>

<div id=event_header>
    <div id=title_box>
        <?php echo $result['name'] ?>
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
</script>
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
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src='/common/img/1.jfif' style='width: 100%;' alt="sally lightfoot crab"/>
            </div>
            <div class="mySlides fade">
                <img  src='/common/img/2.jfif' style='width: 100%;' alt="fighting nazca boobies"/>
            </div>
            <div class="mySlides fade">
                <img  src='/common/img/3.jfif' style='width: 100%;' alt="otovalo waterfall"/>
            </div>
            <div class="mySlides fade">
                <img  src='/common/img/4.jfif' style='width: 100%;' alt="pelican"/>
            </div>
            <a class="prev" onclick='plusSlides(-1)'>&#10094;</a>
            <a class="next" onclick='plusSlides(1)'>&#10095;</a>
            </div>
            <br/>
            <div style='text-align: center;'>
            <span class="dot" onclick='currentSlide(1)'></span>
            <span class="dot" onclick='currentSlide(2)'></span>
            <span class="dot" onclick='currentSlide(3)'></span>
            <span class="dot" onclick='currentSlide(4)'></span>
            </div>
    </div>  
</div>
<div id=news_field>
    Goverment posts and announcements about this event
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>