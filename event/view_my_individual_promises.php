<?php
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
$id=$_SESSION['user_nic'];
$event_id = $_GET['event_id'];
$query="select * from event_".$event_id."_pro_don inner join civilian_detail on civilian_detail.NIC_num = event_".$event_id."_pro_don.to_person where by_person='".$id."' AND (pro_don='promise' OR pro_don='pending');
select * from event_".$event_id."_pro_don inner join civilian_detail on civilian_detail.NIC_num = event_".$event_id."_pro_don.to_person where by_person='".$id."' AND pro_don='donated' ;
select * from event_".$event_id."_pro_don_content inner join event_".$event_id."_pro_don on event_".$event_id."_pro_don_content.don_id = event_".$event_id."_pro_don.id where by_person='".$id."';";

if(mysqli_multi_query($con,$query)){
    $promise_person_detail=[];
    $result=mysqli_store_result($con);
    if(mysqli_num_rows($result)>0){
        $promise_person_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    $donated_person_detail=[];
    mysqli_next_result($con);
    $result=mysqli_store_result($con);
    if(mysqli_num_rows($result)>0){
        $donated_person_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
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
    <title>view my promises</title>
    <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    
    <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
</head>
<body>
<script>
    //btnPress(4);
</script>



<div id='promise_body'>
<div id="title">
    <?php echo "My Promises" ?>
</div>
    <table id='promise_table'>
        <thead>
        <th colspan=1>Full name </th>
        <th colspan=1>Promises</th>
        <th colspan=1>Note</th>
        <th colspan=1>Status</th>
        </thead>

        <?php
            foreach($promise_person_detail as $row_req){
                $item_amount="";
                $name=$row_req['first_name']." ".$row_req['last_name'];
                $note=$row_req['note'];
                $status=$row_req['pro_don'];
                foreach($content_detail as $row_req1){
                    if ($row_req1['don_id']==$row_req['id']){
                    $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                    }
                }
                if ($status=="promise"){
                $to=$row_req['NIC_num'];
                echo "  <tr onclick='edit_promise(\"/event/help/?event_id=".$event_id."&by=".$id."&to=".$to."\")'>
                            <td>".$name."</td><td>".$item_amount."</td>
                            <td>".$note."</td>
                            <td class='not_click'>
                            <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange=''>
                            </td>
                        </tr>";
                }
                else if ($status=="pending"){
                    $to=$row_req['NIC_num'];
                echo "  <tr onclick='edit_promise(\"/event/help/?event_id=".$event_id."&by=".$id."&to=".$to."\")'>
                            <td>".$name."</td><td>".$item_amount."</td>
                            <td>".$note."</td>
                            <td class='not_click'>
                            <input type='checkbox' checked='checked' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange=''>
                            </td>
                        </tr>";
                }
            }
        ?>
    </table>
</div>
<div id='donated_body'>
<div id="title">
    <?php echo "My Donations" ?>
</div>
    <table id='donated_table'>
        <thead>
        <th colspan=1>Full name </th>
        <th colspan=1>Donations</th>
        <th colspan=1>Note</th>
        </thead>

        <?php
            foreach($donated_person_detail as $row_req){
                $item_amount="";
                $name=$row_req['first_name']." ".$row_req['last_name'];
                $note=$row_req['note'];
                foreach($content_detail as $row_req1){
                    if ($row_req1['don_id']==$row_req['id']){
                    $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                    }
                }
                echo "  <td>".$name."</td><td>".$item_amount."</td>
                            <td>".$note."</td>
                        </tr>";
            }
        ?>
    </table>
</div>
</body>
<script>
    function edit_promise(url){
        var target = event.target ? event.target : event.srcElement;
        if(!'not_click toggle btn btn-warning off toggle-group btn btn-success toggle-on btn btn-warning active toggle-off toggle-handle btn btn-default'.includes(target.className)){
            window.location=url;
        }else{
            
        }
    }
</script>

</html>