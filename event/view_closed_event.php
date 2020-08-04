<?php  
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Event</title>
        <link rel="stylesheet" href="/css_codes/view_event.css">
        <link rel="stylesheet" href="/css_codes/style.css">
        <link href="/css_codes/slideshow.css" rel="stylesheet">

    </head>
    <body>
        <script>
            btnPress(4);
        </script>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'];
                    
            if(mysqli_multi_query($con, $query)){
                $sql_result = mysqli_store_result($con);
                $result = mysqli_fetch_assoc($sql_result);
                mysqli_free_result($sql_result);
            }
        ?>
        
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
            </div>
        </div>

        <div id='map_container'>
            <?php require $_SERVER['DOCUMENT_ROOT']."/common/map/map.html"; ?>
        </div>
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

<div id='overlay'>
</div>
<script type="text/javascript" src="/js/slide_show.js"></script>

    </body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
