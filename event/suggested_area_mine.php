<?php  
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
    $event_id=$_GET['event_id'];
    $location_table="event_".$event_id."_locations";
    $Nic_num= $_SESSION['user_nic'];
?>


<head>
    <title>My suggested areas</title>
    <link rel="stylesheet" href='/css_codes/suggested_area_mine.css'>
</head>
<body>
<div class="my_suggest_cont">
    <div class='my_suggest_table_cont'>
        <table class='table_suggested_area'>
            <tr class='table_suggested_area_tr'>
                <th class='table_suggested_area_th'>Type</th>
                <th  class='table_suggested_area_th'>Detail</th>
                <th  class='table_suggested_area_th'></th>
            </tr>
            <?php
            $query="SELECT * FROM $location_table WHERE by_person='$Nic_num'";
            $result=$con->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    echo "<tr class='table_suggested_area_tr' data-areadata='".json_encode($row)."' onclick=add_place_preview(this)>";
                        echo "<td class='table_suggested_area_td'>".ucfirst(explode("_",$row['type'])[0])." area</th>";
                        echo "<td  class='table_suggested_area_td'>".$row['detail']."</th>";
                        echo "<td  class='table_suggested_area_td'><a href='suggested_area_all_delete.php?event_id=".$_GET['event_id']."&location_id=".$row['id']."' class='my_suggest_del'>Delete</a></th>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </div>
    <div class='my_suggest_map_cont'>
        <?php require $_SERVER['DOCUMENT_ROOT']."/common/map/map.html"; ?>
    </div>
</div>
    <?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>
<script>
    var myGeo = new EventGeo();
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