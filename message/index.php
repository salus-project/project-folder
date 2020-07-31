<?php
	require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
	$to_person=isset($_GET['to_person'])?$_GET['to_person']:'';
	$image_tag='';
	$full_name_='';
	$last_seen_sta='';
	if ($to_person != "")	{
		$sql="SELECT first_name,last_name,last_seen FROM civilian_detail WHERE NIC_num='$to_person';";
		$result=$con->query($sql)->fetch_all(MYSQLI_ASSOC);
		$image_tag="<img class='msg_head_img_tag' src='http://d-c-a.000webhostapp.com/Profiles/resized/".$to_person.".jpg'>";
		$full_name_=$result[0]['first_name']." ".$result[0]['last_name'];
	}
	
?>
    <head>
        <title>chat</title>
		<link rel="stylesheet" href='/css_codes/message.css'>
		<script src='/common/autocomplete/auto_complete.js'></script>
    	<link rel='stylesheet' type='text/css' href='/common/autocomplete/auto.css'>
    </head>
    
        <script>
            btnPress(8);
		</script>
	<?php require $_SERVER['DOCUMENT_ROOT']."/message/msg_side_nav.php"; ?>
	<div id="container" class="msg_container">
<?php
		echo "<div class='msg_head_cont'>";
			echo "<div class='Msg_head_image' >".$image_tag."</div>";
			echo "<div class='Msg_head_detail' >";
				echo "<div class='Msg_head_name' >".$full_name_."</div>";
				echo "<div class='Msg_head_last' >".$last_seen_sta."</div>";
			echo "</div>";
		echo "</div>";
	
?>
		<div id="feedback">
		</div>
		<input type="hidden" name="id" id="id" value="<?php echo  $_SESSION['user_nic']; ?>"> 
		<input type="hidden" name="to_person" id="to_person" value="<?php echo  $to_person  ?>">
		<div class='msg_type_cont'>
			<?php
				if ($to_person != "")	{
					echo "<div class='input_tag_cont'>";
					echo '<input type="text" class="chat_input_tag" autocomplete="off" spellcheck="false" name="msg_b" id="msg_b" onkeypress="enterKey(event)" placeholder="type massage here" /> ';  
					echo '</div>';
					echo '<div id="post_btn" class="msg_post_btn" >';
					echo '</div>';
				}
			?>
		</div>
	</div>
	</div>	
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>
			if ($("#to_person").val() !==''){
				var is_success = true;
				var is_loadNew=true;
				var is_last=true;
				var offset=0;
				var xdate=calcTime(5.5);
				var today=xdate;
				var to_person=$("#to_person").val();
				var id=$("#id").val();
				var last_seen;
				var last_id;
				var is_lastSeen = true;
				document.getElementById('feedback').addEventListener("scroll", (e) => {
					loadchats_check();
				});
				//change_top(to_person);

				$(document).ready(function(){
					loadchats();
					setInterval(loadNew,500);
					setInterval(loadLastSeen,1000);
				$("#post_btn").click(function(){
					post_msg();
				});
							
				});
			}
			function enterKey(e){
				if(e.keyCode==13){
					post_msg();
				}
			}
			function post_msg(){
				var message=$("#msg_b").val();
				if(message !==null && message !==""){
					$("#msg_b").val("");
					addMsg(message);
					$.post("post_ajax.php",{to_person:to_person,message:message,id:id},function(data)
					{
						
					});
				}
			}

			
			function loadchats_check(){
				if ($("#feedback").scrollTop() < 100) {
					if(is_success){
						loadchats();
					}
				}
			}
			function loadchats(){
                if(is_success){
                    is_success = false;
					var sql2='SELECT a.id FROM `user_message_'+id+'` as a WHERE a._to="'+to_person+'" and a.status=true ORDER BY a.id DESC limit 0,1;';
					var sql='SELECT * FROM `user_message_'+id+'` AS a WHERE a._to="'+to_person+'" or a._from="'+to_person+'" ORDER BY a.id DESC limit '+offset+',10;'+sql2+' UPDATE `user_message_'+id+'` SET status=true WHERE user_message_'+id+'._from="'+to_person+'";UPDATE `user_message_'+to_person+'` SET status=true WHERE user_message_'+to_person+'._to="'+id+'";';
					
                    $.ajax({url:"load_msg_ajax.php",data: {sql:sql},success:function(result){
						//console.log(result);
						var str=''
						var result=JSON.parse(result);
						if (is_last){
							last_id=result['ads'][0]['id'];
							if(result['adsf'].length>0){
								last_seen=result['adsf'][0]['id'];
							}else{
								last_seen=0;
							}
							is_last=false;
						}
						result=result['ads'];
						for(let i = 0; i < result.length; i++){ 
							var time=c_time(result[i]['time']);
							if(xdate!==dateFormet(result[i]['time'])){
								if(xdate==today){
									str +="<div id='pdate'>Today</div>";
								}else{
									str +="<div id='pdate'>"+xdate+"</div>";
								}
								xdate=dateFormet(result[i]['time']);
							}
							if (result[i]['_from']==null){
								if(result[i]['status']==true){
									var icon="<i class='fa fa-check seen'></i>";
								}else{
									var icon="<i class='fa fa-check unseen "+result[i]['id']+"'></i>";
								}
								str +="<div id='msg_box'><div><i id='mytime'>"+time+"</i> <br><div id='mymsg'>"+result[i]['content']+"</div></div>"+icon+"</div>";
							}
							else{
								str +="<div id='msg_box'><div><i id='time'>"+time+"</i> <br><div id='msg'>"+result[i]['content']+"</div></div></div>";
							}
						}
                        $("#feedback").html(document.getElementById('feedback').innerHTML+str);
                        
                    },complete:function(){
                        is_success = true;
                    }
                    });
                }
				
				offset+=10;
				
			}
			function loadNew(){
				if(is_loadNew && (!is_last)){
                    is_loadNew = false;
					var sql3='SELECT a.id FROM `user_message_'+id+'` as a WHERE a._to="'+to_person+'" and a.status=true and a.id >'+last_seen+' ORDER BY a.id DESC;';
					var sql='SELECT * FROM `user_message_'+id+'` AS a WHERE  (a._to="'+to_person+'" or a._from="'+to_person+'") and a.id > '+last_id+' ORDER BY a.id DESC;'+sql3+' UPDATE `user_message_'+id+'` SET status=true WHERE user_message_'+id+'._from="'+to_person+'";UPDATE `user_message_'+to_person+'` SET status=true WHERE user_message_'+to_person+'._to="'+id+'";';
                    $.ajax({url:"load_msg_ajax.php",data: {sql:sql},success:function(result){
						//console.log(result);
						var str=''
						var result=JSON.parse(result);
						var current_seen=result['adsf'];
						//console.log(current_seen);
						result=result['ads'];
						if(result.length > 0){
							last_id=result[0]['id'];
							for(let i = 0; i < result.length; i++){ 
								var time=c_time(result[i]['time']);
								if (result[i]['_from']==null){
									var icon="<i class='fa fa-check unseen "+result[i]['id']+"'></i>";
									str +="<div id='msg_box'><div><i id='mytime'>"+time+"</i> <br><div id='mymsg'>"+result[i]['content']+"</div></div>"+icon+"</div>";
								}
								else{
									str +="<div id='msg_box'><div><i id='time'>"+time+"</i> <br><div id='msg'>"+result[i]['content']+"</div></div></div>";
								}
							}
							for (var ele of document.getElementsByClassName('temp')){
								ele.outerHTML='';
							}
							$("#feedback").html(str+document.getElementById('feedback').innerHTML);
							for (var ele of document.getElementsByClassName('temp')){
								ele.outerHTML='';
							}
							
						}
                        if(current_seen.length >0){
							for(let i = 0; i < current_seen.length; i++){ 
								document.getElementsByClassName(current_seen[i]['id'])[0].outerHTML="<i class='fa fa-check seen "+current_seen[i]['id']+"'></i>";
							}
							last_seen=current_seen[0]['id'] ;
							
						}

                    },complete:function(){
                        is_loadNew = true;
                    }
                    });
                }
				
			}

			function loadLastSeen(){
				if(is_lastSeen){
					is_lastSeen = false;
					var sql4='SELECT last_seen FROM civilian_detail WHERE NIC_num="'+to_person+'";';
					$.ajax({url:"last_seen_ajax.php",data: {sql4:sql4},success:function(result){
							document.getElementsByClassName('Msg_head_last')[0].outerHTML='<div class="Msg_head_last" >Last seen '+result+'</div>';
					},complete:function(){
							is_lastSeen = true;
						}
						});
				}
			}
			
			function calcTime(offset) {
				var d = new Date();
				var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
				var nd = new Date(utc + (3600000*offset));

				const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(nd)
				const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(nd)
				const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(nd)
				return `${da} ${mo} ${ye}`;
			}
			function dateFormet(dat) {
				var nd = new Date(dat);

				const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(nd)
				const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(nd)
				const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(nd)
				return `${da} ${mo} ${ye}`;
			}
			function c_time(tim){
				if (tim==null){
					var d = new Date();
				}else{
					var d = new Date(tim);
				}
				return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
			}
			function addMsg(message){
				str ="<div id='msg_box' class='temp'><div><i id='mytime'>"+c_time()+"</i> <br><div id='mymsg'>"+message+"</div></div><i class='fa fa-check unseen'></i></div>";
				$("#feedback").html(str+document.getElementById('feedback').innerHTML);			
			}
			function change_top(td){
				var htmlstr=document.getElementsByClassName(td)[0].outerHTML;
				document.getElementsByClassName(td)[0].outerHTML='';
				document.getElementsByClassName('Msg_nav_container')[0].innerHTML=htmlstr+document.getElementsByClassName('Msg_nav_container')[0].innerHTML;
			}
		</script>
		<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
