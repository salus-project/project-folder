<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $id=$_SESSION['user_nic'];
    $person=$_SESSION['first_name']." ".$_SESSION['last_name'];
    $query="select p.*,f.*,f.id AS  fundraising_pro_donid,p.id AS fun_id from fundraising_pro_don f inner join fundraisings p on f.for_fund = p.id where by_person='".$id."';
    select a.id as id,a.don_id as don_id,a.item as item,a.amount as amount,a.pro_don as pro_don,b.by_org as by_org,b.by_person as by_person,b.for_fund as for_fund,b.note as note from fundraising_pro_don_content as a inner join fundraising_pro_don as b on b.id = a.don_id where b.by_person='".$id."';";

    if(mysqli_multi_query($con,$query)){
        $result=mysqli_store_result($con);
        $fundraising_detail=[];
        if(mysqli_num_rows($result)>0){
            $fundraising_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
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
        btnPress(7);
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
                foreach($fundraising_detail as $row_req){
                    $name=$row_req['name'];
                    $by=$row_req['by_civilian'];
                    $fun_id=$row_req['fun_id'];
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
                    for($x=0; $x < count($full_array); $x++ ){
                        $value=$full_array[$x];
                        if(in_array($value,$pending_array)){$checked="checked='checked'";}else{$checked="";}
                        if ($x==0){$name_data="<td rowspan=".count($full_array).">".$name."</td>";$note_data="<td rowspan=".count($full_array).">".$note."</td>";}else{$name_data=$note_data="";}
                
                        echo "  <tr>
                                ".$name_data."
                            <td>".$value."</td>
                            <td class='not_click'>
                            <input type='checkbox'".$checked."data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='toggleFn(this,".$id_arr[$x].",\"".$name."\",\"".$by."\",\"".$fun_id."\")'>
                            </td>
                            ".$note_data."
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
            foreach($fundraising_detail as $row_req){
                $item_amount="";
                $name=$row_req['name'];
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
        </div>
        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>

</body>
<script>
    function edit_promise(url){
        var target = event.target ? event.target : event.srcElement;
        if(!'not_click toggle btn btn-warning off toggle-group btn btn-success toggle-on btn btn-warning active toggle-off toggle-handle btn btn-default'.includes(target.className)){
            window.location=url;
        }else{
            
        }
    }
    function toggleFn(ele,id,fund,id_n,fun_id){
        var person="<?php echo $person ; ?>";
        if (ele.checked){
        var c_status='pending';
        }else{
        var c_status='promise';
        }
        var sql="UPDATE `fundraising_pro_don_content` SET `pro_don` = '"+c_status+"' WHERE `id` = "+id+"";;
        var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         console.log(this.responseText);
        //     }
        // };
        xhttp.open("POST", "/common/postajax/post_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("sql="+sql+"&person="+person+"&fund="+fund+"&status="+c_status+"&id_n="+id_n+"&fun_id="+fun_id+"&type="+3);
    }
</script>

</html>