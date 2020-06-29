<?php
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
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
$query="SELECT a.NIC_num AS nic, a.district AS district, a.village AS village, a.street AS street, b.item AS r_item, b.amount AS r_amount, c.id AS id_, c.by_org AS org, c.by_person AS person, c.note AS note, d.first_name AS first, d.last_name AS last, c.id AS ids, e.org_name as org_name, f.first_name as by_first, f.last_name as by_last FROM $event_name1 AS a INNER JOIN $event_name4 AS b ON (a.NIC_num = b.requester) LEFT OUTER JOIN $event_name2 AS c ON (a.NIC_num = c.to_person) INNER JOIN civilian_detail AS d ON (a.NIC_num = d.NIC_num) LEFT OUTER JOIN organizations AS e ON (c.by_org = e.org_id) LEFT OUTER JOIN civilian_detail AS f ON (c.by_person = f.NIC_num) WHERE a.NIC_num IN ($newarray)";
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
</head>
<body>
<div id="full_body">
    <h2><?php echo $head; ?></h2>
    <div>
        <div class="input_container">
            <div class="input_sub_container">
                <input type="text" class="text_input">
                <input type="text" class="text_input">
                <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
            </div>
        </div>
        <button type="button" onclick="add_to_all(this.previousElementSibling)">Add to all</button>
    </div>
    <div>
        <textarea name="note" class="note"></textarea>
        <button type="button" onclick="note_to_all(this.previousElementSibling)">Add to all</button>
    </div>
    <table id='main_table'>
        <tr><td>Name</td><td>Address</td><td>Requirements</td><td>Other promises</td><td>Your promise</td><td>Note</td></tr>
        <?php
        
        foreach ($arr as $key => $value){
            echo "<tr>";
            
            echo"<td>".$value[1]."</td>";
            echo"<td>".$value[0]."</td>";
        
            echo"<td>";
                foreach($value[2] as $items){
                    echo $items."<br>";
                }
            echo "</td>";
            
            if (empty($value[6]) and empty($value[8])){
                echo "<td>";
                echo "<b>No other promises</b>";
            }
            else{
                echo "<td onclick='other_promises(this)' data-id='".$key."' requests='".implode("<br>",$value[2])."' address='".$value[0]."' name='".$value[1]."'>";

                foreach($value[6] as $orgn){
                    echo $orgn."<br>";
                }
                foreach($value[8] as $pers){
                    echo $pers."<br>";
                }

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
                    array_push($id_a[$key],$row1['id']);
                    echo "<div class='input_sub_container'>";
                    echo "<input type='text' class='text_input' value='".$row1['item']."'>";
                    echo "<input type='text' class='text_input'  value='".$row1['amount']."'>";
                    echo "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                    echo "</div>";  
                }
            }
        }
            echo "<div class='input_sub_container'>";
            echo "<input type='text' class='text_input'>";
            echo "<input type='text' class='text_input'>";
            echo "<button type='button' onclick='add_input(this)' class='add_rem_btn'>Add</button>";
            echo "</div>";
            
            echo "</div>";
            echo "</td>";
            echo "<td class='note_td'>";
            echo "<textarea type=text name=note class=note >".$note."</textarea>";
            echo "</td>";
            echo"</tr>"	;
        }
    
        ?>
        <tr>
            <td colspan='5'>
                <button id="submit_btn" onclick="submit_all()">submit all</button>
            </td>
        </tr>
    </table>
</div>


<script>
    function add_input(element){
        var parent = element.parentElement.parentElement;
        if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
            for (var ele of parent.children) {
                ele.children[0].setAttribute("value", ele.children[0].value);
                ele.children[1].setAttribute("value", ele.children[1].value);
                ele.children[2].outerHTML = "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>"
            }
            parent.innerHTML += '<div class="input_sub_container">\n' +
                '        <input type="text" class="text_input">\n' +
                '        <input type="text" class="text_input">\n' +
                '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\n' +
                '    </div>';
        }
    }
    function remove_input(element){
        element.parentElement.outerHTML='';
    }
    function add_to_all(ele){
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
	function submit_all(){
        var all_td = document.getElementsByClassName("your_promise");
		
		var arr= new Array() ;  		
		for(var td of all_td){
            var idd=td.getAttribute("data-id");
			var promise='';
			for(var tdd of td.firstElementChild.children){
				var val1= tdd.children[0].value;
				var val2= tdd.children[1].value;
				if(val1 != "" ){
					if(val1 != null){
						promise += val1+":"+val2+",";
					}
				}
			}
			var promise = promise.slice(0,promise.length-1);
			var note=td.nextElementSibling.firstElementChild.value;
			var data= idd+"--"+promise+"--"+note;
			arr.push(data);
			
        }
        document.getElementById('datas').value=arr.join("++");
        console.log(arr.join("++"))
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

    <form id="other" action="view_all_promises.php" method=post>
	    <input type="hidden" name="org_id" value=<?php echo $org_id; ?> ><br>
		<input type="hidden" name="event_id" value=<?php echo $event_id; ?> ><br>
        <input type="hidden" name="nic" id="nic" ><br>
        <input type="hidden" name="requests" id="requests" ><br>
        <input type="hidden" name="name" id="name" ><br>
        <input type="hidden" name="address" id="address" ><br>
	</form>


</body>
</html>