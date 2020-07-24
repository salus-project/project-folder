<?php  
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
    $event_id=$_GET['event_id'];
    $location_table="event_".$event_id."_locations";
    $Nic_num= $_SESSION['user_nic'];
?>

<html>
    <head>
        <title>All suggested areas</title>
        <link rel="stylesheet" href='/css_codes/suggested_area_all.css'>
    </head>
    <body>
        <table class='table_suggested_area'>
            <tr class='table_suggested_area_tr'>
                <th class='table_suggested_area_th'>Type</th>
                <th  class='table_suggested_area_th'>By</th>
                <th  class='table_suggested_area_th'>Detail</th>
            </tr>
            <?php
            $query="SELECT a.type AS type,a.detail AS detail, b.first_name AS first, b.last_name AS last, c.org_name AS name FROM `event_2_locations` AS a LEFT OUTER JOIN civilian_detail AS b ON (a.by_person = b.NIC_num) LEFT OUTER JOIN organizations AS c ON (a.by_org = c.org_id)";
            $result=$con->query($query);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    if ($row['name']==""){
                        $by_who=$row['first']." ".$row['last'];
                    }else{
                        $by_who=$row['name'];
                    }
                    echo "<tr class='table_suggested_area_tr'>";
                        echo "<td class='table_suggested_area_td'>".ucfirst(explode("_",$row['type'])[0])." area</th>";
                        echo "<td  class='table_suggested_area_td'>".$by_who."</th>";
                        echo "<td  class='table_suggested_area_td'>".$row['detail']."</th>";
                    echo "</tr>";
                }
            }
            ?>
        </table>

        <?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>
    </body>
</html>