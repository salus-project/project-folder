<?php  
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
    $event_id=$_GET['event_id'];
    $location_table="event_".$event_id."_locations";
    $Nic_num= $_SESSION['user_nic'];
?>


<head>
    <title>My suggested areas</title>
    <link rel="stylesheet" href='/css_codes/suggested_area_mine.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src="/common/map/map.js"></script>
</head>
<body>
<div class="my_suggest_cont">
    <div class='my_suggest_table_cont'>
        <table class='table_suggested_area'>
            <tr>
                <th class='table_suggested_area_th'>Type</th>
                <th  class='table_suggested_area_th'>Detail</th>
                
            </tr>
            <?php
            $query="SELECT * FROM $location_table WHERE by_person='$Nic_num'";
            $result=$con->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo "<tr class='table_suggested_area_tr' data-areadata='".json_encode($row)."' onclick=add_place_preview(this)>";
                        echo "<td class='table_suggested_area_td'>".ucfirst(explode("_",$row['type'])[0])." area</th>";
                        echo "<td  class='table_suggested_area_td'>".$row['detail']."</th>";
                        echo "<td  class='table_suggested_area_th'><a href='suggested_area_all_delete.php?event_id=".$_GET['event_id']."&location_id=".$row['id']."' class='my_suggest_del'>Delete</a></th>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <table class='table_suggested_area'>
            <tr>
                <th class='table_suggested_area_th'>Type</th>
                <th  class='table_suggested_area_th'>By</th>
                <th  class='table_suggested_area_th'>Detail</th>
            </tr>
            <?php
            $query="SELECT $location_table.type,$location_table.detail,$location_table.latitude,$location_table.longitude,$location_table.radius,$location_table.geojson, civilian_detail.first_name, civilian_detail.last_name, organizations.org_name FROM $location_table  LEFT OUTER JOIN civilian_detail  ON ($location_table.by_person = civilian_detail.NIC_num) LEFT OUTER JOIN organizations  ON ($location_table.by_org = organizations.org_id) Where $location_table.by_person <> '$Nic_num' ";
            $result=$con->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    if ($row['org_name']==""){
                        $by_who=$row['first_name']." ".$row['last_name'];
                    }else{
                        $by_who=$row['org_name'];
                    }
                    echo "<tr class='table_suggested_area_tr' data-areadata='".json_encode($row)."' onclick=add_place_preview(this)>";
                        echo "<td class='table_suggested_area_td'>".ucfirst(explode("_",$row['type'])[0])." area</th>";
                        echo "<td  class='table_suggested_area_td'>".$by_who."</th>";
                        echo "<td  class='table_suggested_area_td'>".$row['detail']."</th>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
    <div class='my_suggest_map_cont'>
        <div id='my_suggest_map' style='width:100%;height:100%'></div>
    </div>
</div>
<script>
    var myGeo = new EventGeo('my_suggest_map');
    myGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

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
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>