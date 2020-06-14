<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    
	$f_id=intval($_GET['edit_btn']);
	$query="select * from fundraisings where id=".$f_id;
    $result=($con->query($query))->fetch_assoc();
	
	$fun_id=$result['id'];
	$fundraising_name=$result['name'];
	$service_area=$result['service_area'];
	$description=$result['description'];
	$org_name="";
	$type=$result['type'];
	$for_event=$result['for_event'];
	$for_any=$result['for_any'];
	$money=$result['expecting_money'];
	$things=$result['expecting_things'];

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Edit fundraising event</title>
        <link rel="stylesheet" href="/css_codes/create_fundraising.css">
    </head>
    <body>

    <script>
        btnPress(7);
    </script>

    <div id="main_fund_form_body">
		<center><h2>Edit fundraising event</h2></center>
		<small style="margin:10px;">Edit the details</small>
                <table id='sub_fund_form_body'>
                    <tr>
                        <td colspan='2'>
                            <span id='error'>* required field</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='fundraising_name'>Fundraising event name</label>
                        </td>
                        <td>
                            <input type='text' id="fun_name" name="fundraising_name" value='<?php echo $fundraising_name; ?>'>
                            <span id='error' class="error">* </span>
                        </td>
                    </tr>
					<tr>
                        <td>
                            <label for='organization'>Select organization</label>
                        </td>
                        <td>
                            <select name="organization" id="org_num">
								<option value=''>Not organization based</option>
								<?php
								$query='select * from organizations';
								$result=$con->query($query);
								while($row=$result->fetch_assoc()){
								if($row["leader"]==$_SESSION['user_nic']){
									echo "<option value=" . $row["org_id"] . ">" . $row["org_name"] . "</option>>";
								}else{
									$co_leaders=$row["co_leader"];
									$co_leader = explode(" ", $co_leaders);
									foreach($co_leader as $leader){
										if($leader==$_SESSION['user_nic']){
											echo "<option value=" . $row["org_id"] . ">" . $row["org_name"] . "</option>>";
											break;
										}
									}
								}
								}
								?>
						</td>
					</tr>
					<tr>
                        <td>
                            <label for='event'>Select purpose</label>
                        </td>
                        <td>
							<input type="hidden" id="purp" name="purp" value="00" />
                            <input type='radio' name="purpose" value='' id='event_purpose' onclick='purposeFun()'>For event</br>
							<select name="for_event" id="for_event"  style='display:none'>
                                <?php
								$query='select * from disaster_events';
								$result=$con->query($query);
								while($row=$result->fetch_assoc()){
								echo "<option value=" . $row["event_id"] . ">" . $row["name"] . "</option>>";		
								}
								?>
                            <div style="display:flex; height:20px;">
                                <input type='radio' name="purpose" id='other_purpose_opt' value=''  onclick='purposeFun()'>Other purpose
                                <input type='text' name='other_purpose' id='other_purpose' style='display:none' value=<?php echo $for_any; ?>>
                            </div>
                            
							
                            <script type="text/javascript">
                                
								var for_event = '<?php echo $for_event ?>';

								if(for_event==''){
									document.getElementById("other_purpose_opt").checked=true;
									document.getElementById('other_purpose').style.display='block';
									document.getElementById("for_event").value = "";
									document.getElementById("purp").value = "2";
								}else{
									document.getElementById("event_purpose").checked=true;
									document.getElementById('for_event').style.display='block';
									document.getElementById("other_purpose").value = " ";
									document.getElementById("purp").value = "1";
								}
							
                                function purposeFun(){
                                    if(document.getElementById("other_purpose_opt").checked){
                                        document.getElementById('other_purpose').style.display='block'
										document.getElementById('for_event').style.display='none'
										document.getElementById("purp").value = "2";
										
                                        
                                    }else{
                                        document.getElementById('other_purpose').style.display='none'
										document.getElementById('for_event').style.display='block'
										document.getElementById("purp").value = "1";
										
                                    }
                                }
                            </script>
							<span id='error' class="error">* </span>
						</td>
					</tr>
					<tr>
                        <td>
                            <label for='type'>Your Request</label>
                        </td>
                        <td>
							<input type="hidden" id="mon" name="mon" value="0" />
							<input type="hidden" id="thin" name="thin" value="0" />
							
							<input type="checkbox" id="money" onclick="checkmoneyfn()">Money
							<input type='text' name="expecting_money" id="expecting_money" placeholder='expected money in Rs' style='display:none' value=<?php echo $money; ?>>
							<input type="checkbox" id="things" onclick="checkthingsfn()">Things
							
							<div class="input_container" id=add_i style='display:none'>
								<div class="input_sub_container">
									<input type="text" class="text_input">
									<input type="text" class="text_input">
									<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
								</div>
							</div>
							<input type='hidden' id='hidden' name='hidden'>
							<script>
                                var type = '<?php echo $type ?>';

								if(type=="money only"){
									document.getElementById("money").checked=true;
									document.getElementById('expecting_money').style.display='block';
									document.getElementById("add_i").value = "";
									document.getElementById("mon").value = "1";
									document.getElementById("thin").value = "0";
									
								}else if(type=="things only"){
									document.getElementById("things").checked=true;
									document.getElementById('add_i').style.display='block';
									document.getElementById("expecting_money").value = "";
									document.getElementById("thin").value = "1";
									document.getElementById("mon").value = "0";
								}else{
									document.getElementById("money").checked=true;
									document.getElementById('expecting_money').style.display='block';
									document.getElementById("things").checked=true;
									document.getElementById('add_i').style.display='block';
									document.getElementById("thin").value = "1";
									document.getElementById("mon").value = "1";
								}
							
							
                                function checkmoneyfn(){
                                    if(document.getElementById("money").checked==true){
                                        document.getElementById('expecting_money').style.display='block';
										document.getElementById("mon").value = "1";
                                        
                                    }else{
                                        document.getElementById('expecting_money').style.display='none';
										document.getElementById("mon").value = "0";
                                    }
                                }
								
								function checkthingsfn(){
                                    if(document.getElementById("things").checked==true){
                                        document.getElementById('add_i').style.display='block';
                                        document.getElementById("thin").value = "1";
										
                                    }else{
                                        document.getElementById('add_i').style.display='none';
										document.getElementById("thin").value = "0";
                                    }
                                }
                            </script>
                            <span id='error' class="error">* </span>
						</td>
					</tr>
					<tr>
                        <td>
                            <label>Service area</label>
                        </td>
                        <td>
                            <input type='text' name="service_area" id="service_area" value='<?php echo $service_area; ?>'>
                        </td>
                    </tr>
					<tr>
                        <td>
                            <label>Description</label>
                        </td>
                        <td>
                            <textarea name='description' id="description" ><?php echo $description; ?></textarea>
                        </td>
                    </tr>
					<tr>
                        <td colspan='2'>
                            <button  onclick=submit_data() id='submitBtn' >Update</button>
                        </td>
                    </tr>
				</table>
    
	</div>
    </body>
	
<script>

var type= "<?php echo $type ?>";
if (type !="money only"){
	var request_str= "<?php echo $things ?>";
	var request = request_str.split(",").filter(function(el){
		return el!='';
		});
		
	var str='';	
	request.forEach(myFunction);
	
	function myFunction(item) {
		var req = item.split(":").filter(function(el){
		return el!='';
		});
		str +=  '<div class="input_sub_container">\n' +
                '        <input type="text" class="text_input" value="'+req[0]+'">\n' +
                '        <input type="text" class="text_input" value="'+req[1]+'">\n' +
                '        <button type="button" onclick="remove_input(this)" class="add_rem_btn">Remove</button>\n' +
                '    </div>';
	}
	str += '<div class="input_sub_container">\n' +
                '        <input type="text" class="text_input">\n' +
                '        <input type="text" class="text_input">\n' +
                '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Adde</button>\n' +
                '    </div>';
	document.getElementById('add_i').innerHTML = str;;	
	
}	


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
								
	
	function submit_data(){
        var all_td = document.getElementsByClassName("input_sub_container");
		
		var arr= new Array() ; 
		var promise="" 	;	
		for(var td of all_td){
			var val1= td.children[0].value;
			var val2= td.children[1].value;
				if(val1 != "" ){
					if(val1 != null){
						promise += val1+":"+val2+",";
					}
				}
			}
			var promise = promise.slice(0,promise.length-1);
        arr.push(document.getElementById("fun_name").value);
		arr.push(document.getElementById("org_num").value);
		arr.push(document.getElementById("for_event").value);
		arr.push(document.getElementById("other_purpose").value);
		arr.push(document.getElementById("purp").value);
		arr.push(document.getElementById("mon").value);
		arr.push(document.getElementById("thin").value);
		arr.push(document.getElementById("expecting_money").value);
		arr.push(promise);
		arr.push(document.getElementById("service_area").value);
		arr.push(document.getElementById("description").value);
		
		var post_id="<?php echo $f_id ?>";
		arr.push(post_id);
		
        //console.log(arr);
		
		document.getElementById('list').value=arr.join("++");
		document.getElementById("myForm").submit();
    }
	
	
</script>

	<form id="myForm" action="edit_fundraising_php.php" method=post>
	    <input type="hidden" name="list" id="list"  ><br>
	</form>
	
</html>