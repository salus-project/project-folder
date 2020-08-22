<?php
    
    $org_id= $_POST['org_id'];
    $event_id=$_POST['event_id'];
    $event_name1="event_".$event_id."_pro_don";
    $event_name2="event_".$event_id."_pro_don_content";
    $_GET['org_id']=$org_id;
    $_GET['event_id']=$event_id;
    require $_SERVER['DOCUMENT_ROOT']."/organization/event/org_event_header.php";

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
?>
<link rel="stylesheet" href='/css_codes/org_event_view_all_promises.css'>
<?php
    echo "<table id='promise_table' >";
        echo "<tr><td class='promise_table_td' >Name</th><td class='promise_table_td'>".$_POST['name']."</th></tr>";
        echo "<tr><td class='promise_table_td' >Address</td><td class='promise_table_td'>".$_POST['address']."</td></tr>";
        if ($_POST['requests'] == ":"){
            echo "<tr><td class='promise_table_td'>Requested items</td><td class='promise_table_td'>Not specified anything </td></tr>";
        }else{
            $reqs=explode("++",$_POST['requests']);
            echo "<tr><td class='promise_table_td' rowspan=".count($reqs).">Requested items</td>";
            for ($x = 0; $x <count($reqs); $x++) {
                $item_amount=explode(':',$reqs[$x]);
                if($x==0){
                    echo"<td class='promise_table_td'>".$item_amount[0]." ".$item_amount[1]."</td></tr>";
                }else{
                    echo"<tr><td class='promise_table_td'>".$item_amount[0]." ".$item_amount[1]."</td></tr>";
                }
            }
        }
        
        if (!empty($our)){
            echo "<tr><td class='promise_table_td' rowspan=".count($our).">Our promises</td>";
            for ($x = 0; $x <count($our); $x++) {
                if($x==0){
                    echo"<td class='promise_table_td'>".$our[$x]."</td></tr>";
                }else{
                    echo"<tr><td class='promise_table_td'>".$our[$x]."</td></tr>";
                }
            }
        }
        foreach ($arr as $key => $value){
            $other=array_slice($value,1);
            echo "<tr><td class='promise_table_td' rowspan=".count($other).">$value[0]</td>";
            for ($x = 0; $x <count($other); $x++) {
                if($x==0){
                    echo"<td class='promise_table_td'>".$other[$x]."</td></tr>";
                }else{
                    echo"<tr><td class='promise_table_td'>".$other[$x]."</td></tr>";
                }
            }
        }
    echo "</table>";
    include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";
?>