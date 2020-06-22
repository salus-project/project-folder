<?php
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
$org_id= $_GET['org_id'];
$event_id=$_GET['event_id'];
$event_name1="event_".$event_id."_help_requested";
$event_name2="event_".$event_id."_pro_don";

function console_log($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Promise help</title>
    <link rel="stylesheet" href='/css_codes/promise.css'>
</head>
<body>
<div id="full_body">
    <h2>Promise your help</h2>
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
        $string = $_GET['selected'];
        $str_arr = explode (",", $string);
        //foreach($str_arr as $NIC) {
        //   print($NIC);
        //}
        $array1=[];
        $array2=[];
        $array3=[];
        $array4=[];
        $query1="select * from $event_name2 WHERE by_org=$org_id";
        $result1=$con->query($query1);
        if($result1->num_rows>0){
            while($row1=$result1->fetch_assoc()){
                if (in_array($row1["to_person"], $str_arr)) {
                    if (in_array($row1["to_person"], $array1)) {
                        $key = array_search($row1["to_person"], $array1); 
                        $item=$row1["item"].":".$row1["amount"];
                        $array2[$key]=$array2[$key].",".$item;
                        $array3[$key]=$array3[$key].",".$row1["id"];
                    }else{
                        array_push( $array1,$row1["to_person"]);
                        $item=$row1["item"].":".$row1["amount"];
                        array_push( $array2,$item);
                        array_push( $array3,$row1["id"]);
                        array_push( $array4,$row1["note"]);
                    }
                }
            }
        }
        // console_log($array1);
        // console_log($array2[0]);
        // console_log($array3);
        // console_log($array4);

        $query="select * from $event_name1 ";
        $result=$con->query($query);
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $idd=$row['NIC_num'];
                if (in_array($idd, $str_arr)) {
                    echo "<tr>";
                    $query1="select * from civilian_detail where NIC_num='$idd'";
                    $result1=($con->query($query1))->fetch_assoc();
                    echo"<td>".$result1['first_name']." ".$result1['last_name']."</td>";
                    echo"<td>".$row['street']." ".$row['village']." ".$row['district']."</td>";

                    $request = explode(",", $row['requests']);
                    echo"<td>";
                    foreach($request as $res){
                        echo "$res <br>";
                    }
                    echo"</td>";

                    echo "<td>";

                    $query4="select * from $event_name2 where to_person='$idd' ORDER BY by_org";
                    $result4=$con->query($query4);
                    if($result4->num_rows>0){
                        while($rows=$result4->fetch_assoc()){
                            if ($rows['by_org']==""){
                                $iddd=$rows['by_person'];
                                $query2="select * from civilian_detail where NIC_num='$iddd'";
                                $result2=($con->query($query2))->fetch_assoc();
                                echo "<b>".$result2['first_name']." ".$result2['last_name']."</b>";
                                echo "<br>";
								if ($rows['content'] !=""){
									$string1 = explode (",", $rows['content']);
									foreach($string1 as $str) {
										$string2 = explode (":", $str);
										echo "\t".$string2[0]." ".$string2[1];
										echo "<br>";
									}
								}
                            }
                            else{
                                $o_id=$rows['by_org'];
                                $query3="select * from organizations where org_id=".$o_id;
                                $result3=($con->query($query3))->fetch_assoc();
                                echo "<b>".$result3['org_name']."</b>";
                                echo "<br>";
								if ($rows['content'] !=""){
                                $string1 = explode (",", $rows['content']);
									foreach($string1 as $str) {
										$string2 = explode (":", $str);
										echo "\t".$string2[0]." ".$string2[1];
										echo "<br>";
									}
								}
                            }
                            echo "<br>";
                        }
                    }else{
                        echo "<b>No Promises<b>";
                    }


                    echo "</td>";
					
					//echo "<input type='hidden' id='hidden' name='hidden' value=$idd >";

                    echo "<td class='your_promise' data-id='".$idd."'>";

                    $note='';
                    echo "<div class='input_container'>";
                    if (in_array($idd, $array1)) { 
                        $key = array_search($idd, $array1);
                        $note=$array4[$key]; 
                        $str_items=$array2[$key];
                        $arr_items = explode (",", $str_items);
                            foreach($arr_items as $str) {
                                $stri = explode (":", $str);
                                echo "<div class='input_sub_container'>";
                                echo "<input type='text' class='text_input' value='".$stri[0]."'>";
                                echo "<input type='text' class='text_input'  value='".$stri[1]."'>";
                                echo "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
                                echo "</div>";
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
            }
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
</script>
	<form id="myForm" action="submit.php" method=post>
	    <input type="hidden" name="datas" id="datas"><br>
	    <input type="hidden" name="org_id" value=<?php echo $org_id; ?> ><br>
		<input type="hidden" name="event_id" value=<?php echo $event_id; ?> ><br>
        <input type="hidden" name="array1" value=<?php echo implode(",",$array1); ?> ><br>
        <input type="hidden" name="array3" value=<?php echo implode("++",$array3); ?> ><br>
	</form>
</body>
</html>