<?php
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";
    $id=$_SESSION['user_nic'];
    $person=$_SESSION['first_name']." ".$_SESSION['last_name'];
    $event_id = $_GET['event_id'];
    $query="select * from event_".$event_id."_pro_don inner join civilian_detail on civilian_detail.NIC_num = event_".$event_id."_pro_don.to_person where by_person='".$id."';
    select a.id as id,a.don_id as don_id,a.item as item,a.amount as amount,a.pro_don as pro_don,b.to_person as to_person,b.note as note,b.by_org as by_org,b.by_person as by_person from event_".$event_id."_pro_don_content as a inner join event_".$event_id."_pro_don as b on a.don_id =b.id where b.by_person='".$id."';";

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
        <script src="/js/toggle.js"></script>
        <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
    </head>
    <body>
        <script>
            btnPress(4);
        </script>

    <div class='promise_body'>
        <div class="promise_table_body">
            <table class='promise_table'>
                <tr class="first_head">
                    <th colspan=4>My Promises</th>
                </tr>
                <tr class="second_head">
                    <th colspan=1>Full name </th>   
                    <th colspan=1>Promises</th>
                    <th colspan=1>Status</th>
                    <th colspan=1>Note</th>
                </tr>

            <?php
                foreach($person_detail as $row_req){
                    $name=$row_req['first_name']." ".$row_req['last_name'];
                    $by=$row_req['NIC_num'];
                    $note=$row_req['note'];
                    $promise_array=[];
                    $pending_array=[];
                    $full_array=[];
                    $id_arr=[];
                    foreach($content_detail as $row_req1){
                        if ($row_req1['don_id']==$row_req['id']){
                            $item_amount=$row_req1['item'].":".$row_req1['amount'];
                            if ($row_req1['pro_don']=="promise"){
                                array_push($promise_array,$item_amount);
                            }else if ($row_req1['pro_don']=="pending"){
                                array_push($pending_array,$item_amount);
                            }
                            array_push($full_array,$item_amount);
                            array_push($id_arr,$row_req1['id']);
                        }
                    }
                    $count=count($full_array);
                    for($x=0; $x < count($full_array); $x++ ){
                        $value=$full_array[$x];
                        if(in_array($value,$pending_array)){
                            $checked="checked='checked'";
                        }
                        else{
                            $checked="";
                        }
                        if ($x==0){
                            $name_data_row="<td rowspan=".$count.">".$name."</td>";
                            $note_data_row="<td rowspan=".$count.">".$note."</td>";}
                        else{
                            $name_data_row=$note_data_row="";
                        }
                
                        $to=$row_req['NIC_num'];
                        echo "  <tr onclick='edit_promise(\"/event/help/?event_id=".$event_id."&by=".$id."&to=".$to."\")'>
                                    ".$name_data_row."
                                    <td>".$value."</td>
                                    <td class='not_click'>
                                        <input type='checkbox'".$checked."data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='35' data-offstyle='warning' data-onstyle='success' onchange='toggleFn(this,".$event_id.",\"".$id_arr[$x]."\",\"".$by."\")'>
                                    </td>
                                    ".$note_data_row."
                                </tr>";
                    }
                }
            ?>
        </table>
        </div>
    </div>

    <div class='promise_body'>
        <div class="promise_table_body">
            <table class='promise_table'>
                <tr class="first_head">
                    <th colspan=4> My Donations </th>
                </tr>
                <tr class="second_head">
                    <th colspan=1>Full name </th>   
                    <th colspan=1>Donations</th>
                    <th colspan=1>Note</th>
                </tr>

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
                echo " <tr> <td>".$name."</td>
                            <td>".$item_amount."</td>
                            <td>".$note."</td>
                        </tr>";}
            }
        ?>
        </table>
    </div>
        </div>

<script>
    function edit_promise(url){
        var target = event.target ? event.target : event.srcElement;
        if(!'not_click toggle btn btn-warning off toggle-group btn btn-success toggle-on btn btn-warning active toggle-off toggle-handle btn btn-default'.includes(target.className)){
            window.location=url;
        }else{
            
        }
    }
    function toggleFn(ele,event,id,id_n){
        var person="<?php echo $person ; ?>";
        if (ele.checked){
        var c_status='pending';
        }else{
        var c_status='promise';
        }
        var sql="UPDATE `event_"+event+"_pro_don_content` SET `pro_don` = '"+c_status+"' WHERE `id` = "+id+"";;
        var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         console.log(this.responseText);
        //     }
        // };
        xhttp.open("POST", "/common/postajax/post_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("sql="+sql+"&person="+person+"&event="+event+"&status="+c_status+"&id_n="+id_n+"&type="+1);
    }
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>