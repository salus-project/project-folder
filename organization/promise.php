<?php
require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
$org_id= $_GET['org_id'];
$event_id=$_GET['event_id'];
$event_name1="event_".$event_id."_help_requested";
$event_name2="event_".$event_id."_pro_don";
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
					
					echo "<input type='hidden' id='hidden' name='hidden' value=$idd >";

                    echo "<td class='your_promise'>";
                    ?>

                    <div class="input_container">
                        <div class="input_sub_container">
                            <input type="text" class="text_input">
                            <input type="text" class="text_input">
                            <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
                        </div>
                    </div>

                    <?php
                    echo "</td>";
                    echo "<td class='note_td'>";
                    echo "<textarea type=text name=note class=note></textarea>";
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
            td.innerHTML=ele.innerHTML
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
            var idd=td.previousElementSibling.value;
			var promise='';
			for(var tdd of td.children){
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
		document.getElementById("myForm").submit();
    }
</script>
	<form id="myForm" action="submit.php" method=post>
	    <input type="hidden" name="datas" id="datas"><br>
	    <input type="hidden" name="org_id" value=<?php echo $org_id; ?> ><br>
		<input type="hidden" name="event_id" value=<?php echo $event_id; ?> ><br>
	</form>
</body>
</html>