<?php  
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
?>
<!DOCTYPE html>

<html>
    <head>
        <title>view event</title>
        <link rel="stylesheet" href="/staff/css_codes/view_event.css">
        <link href="/common/map/vector_editor.css?t=1593079387" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
        <script src="/common/map/map.js"></script>
    </head>
    <body>
    <script>
        btnPress(3);
    </script>

        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'];
            $result=($con->query($query))->fetch_assoc();
            $event_status=$result['status'];
            $event_id=$result['event_id'];
            $imgs = array_filter(explode(',', $result['img']));

        ?>
        
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
            </div>
            <div class='edit_close_btn_div'>
            <?php
                echo "<form action=/staff/event/edit_event.php method=GET>";
                echo    "<button type='submit' name=event_id class='edit_button' value=".$event_id."><i class='fa fa-pencil-square-o' style='font-size:20px;color:black;' aria-hidden='true'>Edit</i></button>";
                echo "</form>";
                if($event_status==="active"){
                    echo "<form action=/staff/event/close_event.php method=GET>";
                    echo    "<button type='submit' name=close class='close_button' value=".$event_id."><i class='fa fa-window-close' style='font-size:20px;color:black;' aria-hidden='true'>Close</i></button>";
                    echo "</form>";
                    echo "<form action=/staff/event/delete_event.php method=GET>";
                    echo    "<input type='hidden' name=del value='1'>";
                    echo    "<button type='submit' name=delete class='close_button' value=".$event_id."><i class='fa fa-trash' style='font-size:20px;color:black;' aria-hidden='true'>Delete</i></button>";
                    echo "</form>";
                }else{
                    echo "<form action=/staff/event/delete_event.php method=GET>";
                    echo    "<input type='hidden' name=del value='0'>";
                    echo    "<button type='submit' name=delete class='close_button' value=".$event_id."><i class='fa fa-trash' style='font-size:20px;color:black;' aria-hidden='true'>Delete</i></button>";
                    echo "</form>";
                }
            ?>
            
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
            }#map_container{
                width: 100%;
                height: 400px;
            }
        </style>
        <script>
            var myGeo = new EventGeo('map_container');
            myGeo.markPlace(JSON.parse('<?php  echo $result['geoJson'] ?>'), 'danger', 'Affected area',  true);

        </script>
        <link href="/css_codes/slideshow.css" rel="stylesheet">


        <div class='event_body'> 
        <div class='detail_body'>
            <div class='table_container'>
                <table class='event_table'>
                    <tr>
                        <th colspan=2>
                            Event Detail
                        </th>
                    </tr>
                    <?php
                        foreach($result as $x=>$y){
                            if((ucfirst($x)!="GeoJson" and ucfirst($x)!="Event_id") and (ucfirst($x)=="Name" or ucfirst($x)=="Type" 
                            or ucfirst($x)=="Affected_districts" or ucfirst($x)=="Start_date" or ucfirst($x)=="End_date" or ucfirst($x)=="Status" or ucfirst($x)=="Detail") ){
                                echo "<tr><td>" . ucfirst($x) . "</td><td >" . ucfirst($y) . "</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="img_cont">
            <div class='fund_head' colspan=2>Photos</div>
            <div class='fund_image_conatainer'>
                <div class='img_type'>Profile Image</div>
                <div class="fund_image prim">
                    <img src="http://d-c-a.000webhostapp.com/Event/<?php echo $event_id ?>.jpg" alt="Opps..." class="fund_pic">
                </div>
            </div>
            
            <?php
            foreach ($imgs as $img) {?>
                <div class="fund_image_conatainer">
                <div class='img_type'>Secondary Images</div>
                    <div class="fund_image seco">
                        <img src="http://d-c-a.000webhostapp.com/Event/secondary/<?php echo $img ?>.jpg" alt="Opps..." class="fund_pic">
                    </div>
                </div>
            <?php }
             echo "<div id=img_edit_btn_container >";
                echo "<a href='/staff/event/edit_img?id=".$_GET['event_id']."'>";
                echo "<button id='edit_img_btn' >Edit photos</button>";
                echo "</a>";
                echo"</div>";
                
            ?>
        </div>
        </div>
    </body>
</html>