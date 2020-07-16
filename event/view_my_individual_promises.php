<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    $id=$_SESSION['user_nic'];
    $event_id = $_GET['event_id'];
    $query="select * from event_".$event_id."_pro_don inner join civilian_detail on civilian_detail.NIC_num = event_".$event_id."_pro_don.to_person where by_person='".$id."';
    select * from event_".$event_id."_pro_don_content inner join event_".$event_id."_pro_don on event_".$event_id."_pro_don_content.don_id = event_".$event_id."_pro_don.id where by_person='".$id."';";

    if(mysqli_multi_query($con,$query)){
        $person_detail=[];
        $result=mysqli_store_result($con);
        if(mysqli_num_rows($result)>0){
            $person_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
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
                    <th colspan=1>Full name </th><th colspan=1>Promises</th><th colspan=1>Status</th><th colspan=1>Note</th>
                </thead>

            <?php
                foreach($person_detail as $row_req){
                    $name=$row_req['first_name']." ".$row_req['last_name'];
                    $note=$row_req['note'];
                    $promise_array=[];
                    $pending_array=[];
                    foreach($content_detail as $row_req1){
                        if ($row_req1['don_id']==$row_req['id']){
                            $item_amount=$row_req1['item'].":".$row_req1['amount'];
                            if ($row_req1['pro_don']=="promise"){
                                array_push($promise_array,$item_amount);
                            }else if ($row_req1['pro_don']=="pending"){
                                array_push($pending_array,$item_amount);
                            }
                        }
                    }
                    $full_array=array_merge($pending_array,$promise_array);
                    for($x=0; $x < count($full_array); $x++ ){
                        $value=$full_array[$x];
                        if(in_array($value,$pending_array)){$checked="checked='checked'";}else{$checked="";}
                        if ($x==0){$name_data="<td rowspan=".count($full_array).">".$name."</td>";$note_data="<td rowspan=".count($full_array).">".$note."</td>";}else{$name_data=$note_data="";}
                
                        $to=$row_req['NIC_num'];
                        echo "  <tr onclick='edit_promise(\"/event/help/?event_id=".$event_id."&by=".$id."&to=".$to."\")'>
                                ".$name_data."
                            <td>".$value."</td>
                            <td class='not_click'>
                            <input type='checkbox'".$checked."data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange=''>
                            </td>
                            ".$note_data."
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
                <th colspan=1>Full name </th><th colspan=1>Donations</th><th colspan=1>Note</th>
            </thead>

        <?php
            foreach($person_detail as $row_req){
                $item_amount="";
                $name=$row_req['first_name']." ".$row_req['last_name'];
                $note=$row_req['note'];
                foreach($content_detail as $row_req1){
                    if ($row_req1['don_id']==$row_req['id']){
                        if ($row_req1['pro_don']=="donated"){
                        $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                        }
                    }
                }
                if ($item_amount!=""){
                echo "  <td>".$name."</td><td>".$item_amount."</td>
                            <td>".$note."</td>
                        </tr>";}
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
