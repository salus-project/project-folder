<?php
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";

    $id=$_SESSION['user_nic'];
    $person=$_SESSION['first_name']." ".$_SESSION['last_name'];
    $event_id = $_GET['event_id'];
    $query="select * from event_".$event_id."_pro_don left join civilian_detail on civilian_detail.NIC_num = event_".$event_id."_pro_don.by_person left join organizations on organizations.org_id = event_".$event_id."_pro_don.by_org where to_person='".$id."';
    select a.id as id,a.don_id as don_id,a.item as item,a.amount as amount,a.pro_don as pro_don,b.to_person as to_person,b.note as note,b.by_org as by_org,b.by_person as by_person from event_".$event_id."_pro_don_content as a inner join event_".$event_id."_pro_don as b  on a.don_id = b.id where b.to_person='".$id."';";

    if(mysqli_multi_query($con,$query)){
        $result=mysqli_store_result($con);
        $person_org_detail=[];
        if(mysqli_num_rows($result)>0){
            $person_org_detail=mysqli_fetch_all($result,MYSQLI_ASSOC);
        }

        $content_detail=[];
        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $content_detail = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
    }
    ?>
        <title>view promises on me</title>
        <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="/js/toggle.js"></script>
        <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">

        <script>
            btnPress(4);
        </script>

<div class='promise_body'>
        <div class="promise_table_body">
            <table class='promise_table'>
                <tr class="first_head">
                    <th colspan=4>Promises</th>
                </tr>
                <tr class="second_head">
                    <th colspan=1>Full name </th>   
                    <th colspan=1>Promises</th>
                    <th colspan=1>Status</th>
                    <th colspan=1>Note</th>
                </tr>
                <?php
                    foreach($person_org_detail as $row_req){
                        if ($row_req['org_name']==""){
                            $name=$row_req['first_name']." ".$row_req['last_name'];
                            $by=$row_req['NIC_num'];
                        }
                        else{
                            $name=$row_req['org_name'];
                            $by=$row_req['org_id'];
                        }
                        $note=$row_req['note'];
                        $promise_array=[];
                        $pending_array=[];
                        $full_array=[];
                        $id_arr=[];
                        $pro_pend=[];
                        foreach($content_detail as $row_req1){
                            if ($row_req1['don_id']==$row_req['id']){
                                $item_amount=$row_req1['item'].":".$row_req1['amount'];
                                if (($row_req1['pro_don']=="promise") or ($row_req1['pro_don']=="pending")){
                                    array_push($promise_array,$item_amount);
                                    array_push($id_arr,$row_req1['id']);
                                    array_push($pro_pend,$row_req1['pro_don']);
                                }else if ($row_req1['pro_don']=="donated"){
                                    array_push($pending_array,$item_amount);
                                }
                                array_push($full_array,$item_amount);
                                
                            }
                        }
                        for($x=0; $x < count($promise_array); $x++ ){
                            $value=$promise_array[$x];
                            if(in_array($value,$pending_array)){
                                $checked="checked='checked'";}
                            else{
                                $checked="";}
                            if ($x==0){
                                $name_data_row="<td rowspan=".count($promise_array).">".$name."</td>";
                                $note_data_row="<td rowspan=".count($promise_array).">".$note."</td>";}
                            else{
                                $name_data_row=$note_data_row="";}
                        if ($pro_pend[$x]=="promise"){
                            $data_off="Not helped";
                        } else{
                            $data_off="Claimed";
                        }
                        echo "  <tr onclick='edit_promise(\"/event/help/?event_id=".$event_id."&by=".$by."&to=".$id."\")'>
                            ".$name_data_row."
                            <td>".$value."</td>
                            <td class='not_click'>
                            <div onclick='confirmFn(this,".$id_arr[$x].",".$event_id.",\"".$name."\",\"".$by."\")'><input type='checkbox' id='checkbox' disabled data-toggle='toggle' data-on='Helped' data-off='".$data_off."' data-width='100' data-height='35' data-offstyle='warning' data-onstyle='success' onchange='this.checked = !this.checked' ></div>
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
                    <th colspan=4> Donations </th>
                </tr>
                <tr class="second_head">
                    <th colspan=1>Full name </th>   
                    <th colspan=1>Donations</th>
                    <th colspan=1>Note</th>
                </tr>
                <?php
                    foreach($person_org_detail as $row_req){
                        if ($row_req['org_name']==""){
                            $name=$row_req['first_name']." ".$row_req['last_name'];
                            $by=$row_req['NIC_num'];
                        }
                        else{
                            $name=$row_req['org_name'];
                            $by=$row_req['org_id'];
                        }
                        $item_amount=[];
                        $note=$row_req['note'];
                        $rows=0;
                        foreach($content_detail as $row_req1){
                            if ($row_req1['don_id']==$row_req['id']){
                                if ($row_req1['pro_don']=="donated"){
                                array_push($item_amount,$row_req1['item'].":".$row_req1['amount']);
                                $rows += 1;
                            }
                            }
                        }
                        if (count($item_amount)>0){
                            for($x=0; $x < $rows; $x++ ){
                                if ($x==0){
                                    $name_data_row="<td rowspan=".$rows.">".$name."</td>";
                                    $note_data_row="<td rowspan=".$rows.">".$note."</td>";
                                }
                                else{
                                    $name_data_row=$note_data_row="";
                                }
                                echo "<tr>".$name_data_row."<td>".$item_amount[$x]."</td>".$note_data_row."</tr>";
                            }
                        }
                    }   
                ?>
            </table>
        </div>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function edit_promise(url){
            var target = event.target ? event.target : event.srcElement;
            if(!'not_click toggle btn btn-warning off toggle-group btn btn-success toggle-on btn btn-warning active toggle-off toggle-handle btn btn-default'.includes(target.className)){
                window.location=url;
            }else{
                
            }
        }
        function confirmFn(ele,id,event,name,id_n) {
            swal({
                title: "Are you sure?",
                text: "Once confirmed, you will not be able to change this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                if (willDelete) {
                    toggleFn(event,id,name,id_n);
                    ele.outerHTML='<div class="toggle btn btn-success" data-toggle="toggle" disabled="disabled" style="width: 100px; height: 15px;"><input type="checkbox" id="checkbox" checked="" disabled="" data-toggle="toggle" data-on="Helped" data-off="Not helped" data-width="100" data-height="15" data-offstyle="warning" data-onstyle="success" onchange="this.checked = !this.checked"><div class="toggle-group"><label class="btn btn-success toggle-on" style="line-height: 20px;">Helped</label><label class="btn btn-warning active toggle-off" style="line-height: 20px;">Not helped</label><span class="toggle-handle btn btn-default"></span></div></div>';
                } 
            });
        }


        function toggleFn(event,id,name,id_n){
        var person="<?php echo $person ; ?>";
        var sql="UPDATE `event_"+event+"_pro_don_content` SET `pro_don` = 'donated' WHERE `id` = "+id+"";;
        var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         console.log(this.responseText);
        //     }
        // };
        xhttp.open("POST", "/common/postajax/post_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("sql="+sql+"&person="+person+"&name="+name+"&event="+event+"&id_n="+id_n+"&type="+2);

    }
    </script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>