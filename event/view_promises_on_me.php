<?php
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
$id=$_SESSION['user_nic'];
$event_id = $_GET['event_id'];
$query="select * from event_".$event_id."_pro_don inner join civilian_detail on civilian_detail.NIC_num = event_".$event_id."_pro_don.by_person where to_person='".$id."';
select * from event_".$event_id."_pro_don inner join organizations on organizations.org_id = event_".$event_id."_pro_don.by_org where to_person='".$id."';
select * from event_".$event_id."_pro_don_content inner join event_".$event_id."_pro_don on event_".$event_id."_pro_don_content.don_id = event_".$event_id."_pro_don.id where to_person='".$id."';";

if(mysqli_multi_query($con,$query)){
    $result=mysqli_store_result($con);
    $person_detail=[];
    if(mysqli_num_rows($result)>0){
        $person_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    $org_detail=[];
    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $org_detail = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
    $content_detail=[];
    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $content_detail = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>view promises on me</title>
    <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
</head>
<body>
<script>
    btnPress(4);
</script>

<div id="title">
    <?php echo "Promises on me" ?>
</div>

<div id='promise_body'>
    <table id='promise_table'>
        <thead>
        <th colspan=1>Full name </th>
        <th colspan=1>Promises</th>
        <th colspan=1>Note</th>
        </thead>

        <?php
            foreach($person_detail as $row_req){
                $item_amount="";
                $name=$row_req['first_name'].$row_req['last_name'];
                $note=$row_req['note'];
                foreach($content_detail as $row_req1){
                    if ($row_req1['don_id']==$row_req['id']){
                    $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                    }
                }
                echo "<tr>
            <td>".$name."</td><td>".$item_amount."</td><td>".$note."</td>
            </tr>";
            }
            foreach($org_detail as $row_req){
                $item_amount="";
                $name=$row_req['org_name'];
                $note=$row_req['note'];
                foreach($content_detail as $row_req1){
                    if ($row_req1['don_id']==$row_req['id']){
                    $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                    }
                }
                echo "<tr>
            <td>".$name."</td><td>".$item_amount."</td><td>".$note."</td>
            </tr>";
            }
            
        ?>
    </table>
</div>
</body>

</html>