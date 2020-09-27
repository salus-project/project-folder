<?php 
    require $_SERVER['DOCUMENT_ROOT']."/organization/event/org_event_header.php";
    $org_id = $_GET['org_id'];
    $event_id = $_GET['event_id'];
    $location_table="event_".$event_id."_locations";
?>
<html>
    <head>
        <title>view marked areas and places</title>
        <link rel="stylesheet" href='/css_codes/org_marked_area_place.css'>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
        <script src="/common/map/map.js"></script>
    </head>
    <body>
    <div class="our_suggest_cont">
        <div class='our_suggest_table_cont'>   
            <table class='table_marked_ap'>
                <tr class='table_marked_ap_tr'>
                    <th class='table_marked_ap_th'>Type</th>
                    <th  class='table_marked_ap_th'>Detail</th>
                    <th  class='table_marked_ap_th'></th>
                </tr>
                <?php
                $query="SELECT * FROM $location_table WHERE by_org=$org_id";
                $result=$con->query($query);
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        echo "<tr class='table_marked_ap_tr' data-areadata='".json_encode($row)."' onclick=add_place_preview(this)>";
                            echo "<td class='table_marked_ap_td'>".ucfirst(explode("_",$row['type'])[0])." area</th>";
                            echo "<td  class='table_marked_ap_td'>".$row['detail']."</th>";
                            echo "<td  class='table_marked_ap_td'><a href='org_marked_area_place_delete.php?event_id=".$_GET['event_id']."&location_id=".$row['id']."' class='my_suggest_del'>Delete</a></th>";
                        echo "</tr>";
                    }
                }else{
                    echo "<td colspan=3 class='table_suggested_area_td'>No areas were suggested any area</td>";
                }
                ?>
            </table>
        </div>
        <div class='our_suggest_map_cont'>
            <div id='my_suggest_map' style='width:100%;height:100%'></div>
        </div>
    </div>
        <script>
            // document.getElementsByClassName('org_event_select_first')[0].outerHTML='';
            document.getElementsByClassName('org_event_select_marked')[0].outerHTML="<option selected class='org_event_select_marked'  value='/organization/event/org_marked_area_place.php?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>'>"
                                                                                    +   "<div id='marked_area_btn_container'>"
                                                                                    +      "<a >Marked Area</a>"
                                                                                    +   "</div>"
                                                                                    +"</option>";
                                                                                    
            var myGeo = new EventGeo('my_suggest_map');
            myGeo.markPlace(/*areaGeoJson*/'', 'danger', 'Affected area',  true);

            var remove=false;

            function add_place_preview(ele){
                if(remove){
                    myGeo.remove_last_place_circle();
                }else{
                    remove=true;
                }
                create_place(JSON.parse(ele.dataset.areadata),true);
            }
        </script>
        <?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>
    </body>
</html>