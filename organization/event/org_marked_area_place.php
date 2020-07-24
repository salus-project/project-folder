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
                    echo "<tr class='table_marked_ap_tr'>";
                        echo "<td class='table_marked_ap_td'>".ucfirst(explode("_",$row['type'])[0])." area</th>";
                        echo "<td  class='table_marked_ap_td'>".$row['detail']."</th>";
                        echo "<td  class='table_marked_ap_td'><a href='org_marked_area_place_delete.php?event_id=".$_GET['event_id']."&location_id=".$row['id']."' class='my_suggest_del'>Delete</a></th>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        </div>
    <div class='our_suggest_map_cont'>
    Map Map Map
    </div>
    <div>
        <script>
            // document.getElementsByClassName('org_event_select_first')[0].outerHTML='';
            document.getElementsByClassName('org_event_select_marked')[0].outerHTML="<option selected class='org_event_select_marked'  value='/organization/event/org_marked_area_place.php?org_id=<?php echo $_GET['selected_org'] ?>&event_id=<?php echo $_GET['event_id'] ?>'>"
                                                                                    +   "<div id='marked_area_btn_container'>"
                                                                                    +      "<a >Marked Area</a>"
                                                                                    +   "</div>"
                                                                                    +"</option>";
        </script>
        <?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>
    </body>
</html>