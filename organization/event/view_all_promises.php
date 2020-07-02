<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $org_id= $_POST['org_id'];
    $event_id=$_POST['event_id'];
    $event_name1="event_".$event_id."_pro_don";
    $event_name2="event_".$event_id."_pro_don_content";

    // echo $_POST["requests"];
    // echo $_POST["name"];
    // echo $_POST["address"];

    $arr=[];
    $our=[];
    $query="SELECT a.by_org as org, a.by_person as person, b.item as item, b.amount as amount, c.org_name AS org_name, d.first_name as first, d.last_name as last FROM $event_name1 AS a INNER JOIN $event_name2 AS b ON (a.id = b.don_id) LEFT OUTER JOIN organizations AS c ON a.by_org = c.org_id LEFT OUTER JOIN civilian_detail AS d ON a.by_person = d.NIC_num Where a.to_person='".$_POST["nic"]."' ORDER BY a.by_person";
    $result=$con->query($query);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            if ($row['org']!=""){
                if($row['org']==$org_id){
                    array_push($our,$row['item']." ".$row['amount']);
                }
                else {
                    if(array_key_exists($row['org'],$arr)){
                        array_push($arr[$row['org']],$row['item']." ".$row['amount']);
                    }
                    else{
                        $arr[$row['org']]=[$row['org_name'],$row['item']." ".$row['amount']];
                    }
                }
            }
            if ($row['person']!=""){
                if(array_key_exists($row['person'],$arr)){
                    array_push($arr[$row['person']],$row['item']." ".$row['amount']);
                }
                else{
                    $arr[$row['person']]=[$row['first']." ".$row['last'],$row['item']." ".$row['amount']];
                }
                
            }
        }
    }
    // var_dump($arr);

    echo "<table id='promise_table'>";
        echo "<tr><td>Name</td><td>".$_POST['name']."</td></tr>";
        echo "<tr><td>Address</td><td>".$_POST['address']."</td></tr>";
        echo "<tr><td>Requested items</td><td>".$_POST['requests']."</td></tr>";
        if (!empty($our)){
            echo "<tr><td>Our promises</td><td>".implode("<br>",$our)."</td></tr>";
        }
        foreach ($arr as $key => $value){
            echo "<tr><td>".$value[0]."</td><td>".implode("<br>",array_slice($value,1))."</td></tr>";
        }
    echo "</table>";
    include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";
?>