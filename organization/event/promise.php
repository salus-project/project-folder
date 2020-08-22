<?php
    require $_SERVER['DOCUMENT_ROOT']."/organization/event/org_event_header.php";
    $org_id= $_GET['org_id'];
    $event_id=$_GET['event_id'];
    $event_name1="event_".$event_id."_help_requested";
    $event_name2="event_".$event_id."_pro_don";
    $event_name3="event_".$event_id."_pro_don_content";
    $event_name4="event_".$event_id."_requests";
    if ($_GET['type']=="1"){
        $head="Promise your help";
    }else{ 
        $head="Edit your promise";
    }
    function console_log($data) {
        $output = $data; 
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
    $id_s=[];
    $id_a=[];
    $arr=[];
    $string = $_GET['selected'];
    $str_arr = explode (",", $string);
    $newarray = "'".implode("', '", $str_arr)."'";
    $query="SELECT a.NIC_num AS nic, a.district AS district, a.village AS village, a.street AS street, b.item AS r_item, b.amount AS r_amount, c.id AS id_, c.by_org AS org, c.by_person AS person, c.note AS note, d.first_name AS first, d.last_name AS last, c.id AS ids, e.org_name as org_name, f.first_name as by_first, f.last_name as by_last FROM $event_name1 AS a LEFT OUTER JOIN $event_name4 AS b ON (a.NIC_num = b.requester) LEFT OUTER JOIN $event_name2 AS c ON (a.NIC_num = c.to_person) INNER JOIN civilian_detail AS d ON (a.NIC_num = d.NIC_num) LEFT OUTER JOIN organizations AS e ON (c.by_org = e.org_id) LEFT OUTER JOIN civilian_detail AS f ON (c.by_person = f.NIC_num) WHERE a.NIC_num IN ($newarray)";
    $result=$con->query($query);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            if (array_key_exists($row['nic'],$arr)){
                if($row['org']!=""){
                    if($row['org']==$org_id){
                        $arr[$row['nic']][3]=$row['ids'];
                        $arr[$row['nic']][4]=$row['note'];
                        $id_s[$row['nic']]=$row['id_'];
                    }
                    else{
                        if (!in_array($row['org'],$arr[$row['nic']][5])){
                            array_push($arr[$row['nic']][5],$row['org']);
                            array_push($arr[$row['nic']][6],$row['org_name']);
                        }
                    }
                }
                if($row['person']!=""){
                    if (!in_array($row['person'],$arr[$row['nic']][7])){
                        array_push($arr[$row['nic']][7],$row['person']);
                        array_push($arr[$row['nic']][8],$row['by_first']." ".$row['by_last']);
                    }
                }
                if($row['r_item'] != ""){
                    $ite=$row['r_item'].":".$row['r_amount'];
                    if (!in_array($ite,$arr[$row['nic']][2])){
                        array_push($arr[$row['nic']][2],$ite);
                    }
                }
            }
            else {
                $arr[$row['nic']]=[$row['district'].' '.$row['village'].' '.$row['street'],$row['first'].' '.$row['last'],[$row['r_item'].":".$row['r_amount']],'','',[],[],[],[]];
                if($row['org']!=""){
                    if($row['org']==$org_id){
                        $arr[$row['nic']][3]=$row['ids'];
                        $arr[$row['nic']][4]=$row['note'];
                        $id_s[$row['nic']]=$row['id_'];
                    }
                    else{
                        array_push($arr[$row['nic']][5],$row['org']);
                        array_push($arr[$row['nic']][6],$row['org_name']);
                    }
                }if($row['person']!=""){
                    array_push($arr[$row['nic']][7],$row['person']);
                    array_push($arr[$row['nic']][8],$row['by_first']." ".$row['by_last']);
                    
                }
            }   
        }
    }
   
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $head; ?></title>
        <link rel="stylesheet" href='/css_codes/promise.css'>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
    
    </head>
    <body>
    <div id="full_body">
        <div class="promise_header">
            <?php echo $head; ?>
        </div>
        <div style="display:flex;">
            <div class="input_container">
                <div class="input_sub_container">
                    <input type="text" class="text_input" placeholder="item">
                    <input type="text" class="text_input" placeholder="amount">
                    <div class='status_div'>
                        <div class='toggle btn btn-waarning off' data-toggle='toggle' style='width: 100px; height: 15px;' onclick='click_checkbox(this)'>
                            <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='checkbox_change(this)'>
                            <div class='toggle-group'>
                                <label class='btn btn-success toggle-on' style='line-height: 20px;'>
                                    Helped
                                </label>
                                <label class='btn btn-warning active toggle-off' style='line-height: 20px;'>
                                    Not helped
                                </label>
                                <span class='toggle-handle btn btn-default'></span>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
                </div>
            </div>
            <button type="button" class="add_to_all" onclick="add_to_all(this.previousElementSibling)">Add to all</button>
        </div>
        <div style="display:flex;">
            <textarea placeholder="Add a note" name="note" class="note"></textarea>
            <button type="button" class="add_to_all" onclick="note_to_all(this.previousElementSibling)">Add to all</button>
        </div>
            
        <div class="promise_table_body">
            <table class='promise_table'>
                <tr class="first_head">
                    <th colspan=6>Promise Details</th>
                </tr>
                <tr class="second_head"><th>Name</th><th>Address</th><th>Requirements</th><th>Other promises</th><th>Your promise</th><th>Note</th></tr>
                <?php
                foreach ($arr as $key => $value){
                    echo "<tr>";
                    
                    echo"<td>".$value[1]."</td>";
                    echo"<td>".$value[0]."</td>";
                
                    echo"<td>";
                        if ($value[2]==[':']){
                            echo "Not specified anything <br>";
                        }else{
                            foreach($value[2] as $items){
                                echo $items."<br>";
                            }
                        }
                    echo "</td>";
                    
                    if (empty($value[6]) and empty($value[8])){
                        echo "<td>";
                        echo "<b>No other promises</b>";
                    }
                    else{
                        echo "<td onclick='other_promises(this)' data-id='".$key."' requests='".implode("++",$value[2])."' address='".$value[0]."' name='".$value[1]."'>";

                        foreach($value[6] as $orgn){
                            echo $orgn."<br>";
                        }
                        foreach($value[8] as $pers){
                            echo $pers."<br>";
                        }
                        echo "<br><span class='view_all_promise' >view all</span>";
                    }
                   
                    echo "</td>";
                    $note=$value[4];
                    $id=$value[3];
                    echo "<td class='your_promise' data-id='".$key."'>";

                    echo "<div class='input_container'>";
                    if ( $id !="" ){
                        $id_a[$key]=[];
                        $query1="SELECT * FROM $event_name3  WHERE don_id= $id";
                        $result1=$con->query($query1);
                        if($result1->num_rows>0){
                            while($row1=$result1->fetch_assoc()){
                            if($row1['pro_don']!="donated"){
                                array_push($id_a[$key],$row1['id']); 
                                if($row1['pro_don']=="promise"){
                                    $checcked = '';
                                    $div_class = 'btn-warning off'; 
                                }
                                elseif($row1['pro_don']=="pending"){
                                    $checcked = "checked";
                                    $div_class = 'btn-success';
                                }
                                echo "<div class='input_sub_container'>";
                                echo "      <input type='text' class='text_input' value='".$row1['item']."'>";
                                echo "      <input type='text' class='text_input'  value='".$row1['amount']."'>";
                                echo "      <div class='status_div'>";
                                echo "          <div class='toggle btn  {$div_class}' data-toggle='toggle' style='width: 100px; height: 15px;' onclick='click_checkbox(this)'>";
                                echo "            <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' {$checcked} onchange='checkbox_change(this)' {$checcked}>";
                                echo "            <div class='toggle-group'>";
                                echo "                <label class='btn btn-success toggle-on' style='line-height: 20px;'>";
                                echo "                    Helped";
                                echo "                </label>";
                                echo "                <label class='btn btn-warning active toggle-off' style='line-height: 20px;'>";
                                echo "                    Not helped";
                                echo "                </label>";
                                echo "                <span class='toggle-handle btn btn-default'></span>";
                                echo "            </div>";
                                echo "        </div>";
                                echo "    </div>";
                                echo "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                                echo "</div>";  
                            }
                        }
                    }
                }
                    echo "<div class='input_sub_container'>";
                    echo "      <input type='text' class='text_input' placeholder='item'>";
                    echo "      <input type='text' class='text_input' placeholder='amount'>";
                    echo "      <div class='status_div'>";
                    echo "          <div class='toggle btn btn-waarning off' data-toggle='toggle' style='width: 100px; height: 15px;' onclick='click_checkbox(this)'>";
                    echo "              <input type='checkbox' data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='checkbox_change(this)'>";
                    echo "              <div class='toggle-group'>";
                    echo "                  <label class='btn btn-success toggle-on' style='line-height: 20px;'>";
                    echo "                      Helped";
                    echo "                  </label>";
                    echo "                  <label class='btn btn-warning active toggle-off' style='line-height: 20px;'>";
                    echo "                      Not helped";
                    echo "                  </label>";
                    echo "                  <span class='toggle-handle btn btn-default'></span>";
                    echo "              </div>";
                    echo "          </div>";
                    echo "      </div>";
                    echo "      <button type='button' onclick='add_input(this)' class='add_rem_btn'>Add</button>";
                    echo "</div>";
                    
                    echo "</div>";
                    echo "</td>";
                    echo "<td class='note_td'>";
                    echo "<textarea type=text name=note class=note_td_edit >".$note."</textarea>";
                    echo "</td>";
                    echo"</tr>"	;
                }
            
                ?>
                <tr>
                    <td style="padding:0px;" colspan='6'>
                        <button id="submit_btn" class="submit_all_btn" onclick="submit_all()">submit all</button>
                        <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button id="cancel_btn" type="button" class="submit_all_btn" onclick="submit_all()">Cancel</button></a>

                    </td>
                </tr>
            </table>
        </div>
        </div>

        <script>
            function add_input(element){
                var parent = element.parentElement.parentElement;
                if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
                    for (var ele of parent.children) {
                        ele.children[0].setAttribute("value", ele.children[0].value);
                        ele.children[1].setAttribute("value", ele.children[1].value);
                        ele.children[3].outerHTML = "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>"
                    }
                    parent.innerHTML += '<div class="input_sub_container">\n' +
                        '        <input type="text" class="text_input" placeholder="item">\n' +
                        '        <input type="text" class="text_input" placeholder="amount">\n' +
                        '        <div class="status_div">\n'+
                        '           <div class="toggle btn btn-waarning off" data-toggle="toggle" style="width: 100px; height: 15px;" onclick="click_checkbox(this)">\n'+
                        '               <input type="checkbox" data-toggle="toggle" data-on="Helped" data-off="Not helped" data-width="100" data-height="15" data-offstyle="warning" data-onstyle="success" onchange="checkbox_change(this)">\n'+
                        '               <div class="toggle-group">\n'+
                        '                   <label class="btn btn-success toggle-on" style="line-height: 20px;">\n'+
                        '                       Helped\n'+
                        '                   </label>\n'+
                        '                   <label class="btn btn-warning active toggle-off" style="line-height: 20px;">\n'+
                        '                       Not helped\n'+
                        '                   </label>\n'+
                        '                   <span class="toggle-handle btn btn-default"></span>\n'+
                        '               </div>\n'+
                        '           </div>\n'+
                        '        </div>\n'+
                        '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\n' +
                        '    </div>';
                }
            }
            function remove_input(element){
                element.parentElement.outerHTML='';
            }
            function add_to_all(ele){
                var last = ele.lastElementChild;
                last.children[0].setAttribute("value", last.children[0].value);
                last.children[1].setAttribute("value", last.children[1].value);
                var all_td = document.getElementsByClassName("your_promise");
                for(var td of all_td){
                    td.innerHTML=ele.outerHTML;
                }
            }
            function note_to_all(ele){

                var all_td = document.getElementsByClassName("note_td");
                for(var td of all_td){
                    td.firstElementChild.value = ele.value;
                }
            }
            function click_checkbox(ele){
                //ele.firstElementChild.toggleAttribute("checked");
                ele.firstElementChild.click();
            }
            function checkbox_change(element){
                element.parentElement.classList.toggle('btn-warning');
                element.parentElement.classList.toggle('off');
                element.parentElement.classList.toggle('btn-success');
                element.toggleAttribute("checked");
                if(element.checked){
                    element.nextElementSibling.value='pending';
                }else{
                    element.nextElementSibling.value='promise';
                }
            }
            function submit_all(){
                var all_td = document.getElementsByClassName("your_promise");
                
                var arr= new Array() ;  		
                for(var td of all_td){
                    var idd=td.getAttribute("data-id");
                    var promise='';
                    for(var tdd of td.firstElementChild.children){
                        var val1= tdd.children[0].value;
                        var val2= tdd.children[1].value;
                        var checked="";
                        if (!((val1 == "" ) || (val1 == null))){
                            if(tdd.children[2].children[0].children[0].checked){
                                checked +="pending";
                            }else{
                                checked +="promise";
                            }
                            promise += val1+":"+val2+":"+checked+",";
                        }
                        
                    }
                    var promise = promise.slice(0,promise.length-1);
                    var note=td.nextElementSibling.firstElementChild.value;
                    var data= idd+"--"+promise+"--"+note;
                    arr.push(data);
                    
                }
                document.getElementById('datas').value=arr.join("++");
                //console.log(arr.join("++"))
                document.getElementById("myForm").submit();
            }

            function other_promises(nic){
                document.getElementById('nic').value=nic.getAttribute("data-id");
                document.getElementById('requests').value=nic.getAttribute("requests");
                document.getElementById('name').value=nic.getAttribute("name");
                document.getElementById('address').value=nic.getAttribute("address");
                document.getElementById("other").submit();
            }
        </script>
        <form id="myForm" action="submit.php" method=post>
            <input type="hidden" name="datas" id="datas"><br>
            <input type="hidden" name="org_id" value=<?php echo $org_id; ?> ><br>
            <input type="hidden" name="event_id" value=<?php echo $event_id; ?> ><br>
            <input type="hidden" name="array1" value=<?php echo serialize($id_a); ?> ><br>
            <input type="hidden" name="array2" value=<?php echo serialize($id_s); ?> ><br>
        </form>

        <form id="other" action="view_all_promises.php" method=POST>
            <input type="hidden" name="org_id" value=<?php echo $org_id; ?> ><br>
            <input type="hidden" name="event_id" value=<?php echo $event_id; ?> ><br>
            <input type="hidden" name="nic" id="nic" ><br>
            <input type="hidden" name="requests" id="requests" ><br>
            <input type="hidden" name="name" id="name" ><br>
            <input type="hidden" name="address" id="address" ><br>
        </form>
        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
    </body>
</html>