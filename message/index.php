<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
	$to_person= '982812763V';
	//$to_person= '983270751V';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>chat</title>
        <link rel="stylesheet" href='/css_codes/message.css'>
		
    </head>
    <body>
        <script>
            document.getE
            btnPress(8);
        </script>
	<div id="container">
	<h1>Group Disscussion</h1>
	
		<div id="feedback">
		</div>

		<input type=""text"  autocomplete="off" spellcheck="false" name="msg_b" id="msg_b" onkeypress="enterKey(event)" placeholder="type massage here" />   
        <input type="hidden" name="id" id="id" value="<?php echo  $_SESSION['user_nic']; ?>"> 
		<input type="hidden" name="to_person" id="to_person" value="<?php echo  $to_person  ?>">
		<button id="post_btn" type="button">Send</button>
		<span id="status"></span>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>
			var is_success = true;
			var is_loadNew=true;
			var offset=0;
			var xdate=calcTime(5.5);
			var to_person=$("#to_person").val();
			var id=$("#id").val();

			document.getElementById('feedback').addEventListener("scroll", (e) => {
            	loadchats_check();
			});
			
			document.getElementById('feedback').addEventListener("scroll", (e) => {
				post_msg()
			});

			$(document).ready(function(){
				loadchats();
				setInterval(loadNew,500);
			$("#post_btn").click(function(){
				post_msg();
			});
						
			});
			function enterKey(e){
				if(e.keyCode==13){
					post_msg();
				}
			}
			function post_msg(){
				var message=$("#msg_b").val();
				if(message !==null && message !==""){
					$.post("post_ajax.php",{to_person:to_person,message:message,id:id},function(data)
					{
						$("#status").html(data);
						$("#msg_b").val("");
						addMsg(message);
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
					var sql='SELECT * FROM `user_message_'+id+'` AS a WHERE a.to="'+to_person+'" or a.from="'+to_person+'" ORDER BY a.id DESC limit '+offset+',10; UPDATE `user_message_'+id+'` SET status=true WHERE user_message_'+id+'.from="'+to_person+'";UPDATE `user_message_'+to_person+'` SET status=true WHERE user_message_'+to_person+'.to="'+id+'";';
                    $.ajax({url:"load_msg_ajax.php",data: {sql:sql},success:function(result){
						var str=''
						var result=JSON.parse(result);
						for(let i = 0; i < result.length; i++){ 
							var time=c_time(result[i]['time']);
							if(xdate!==dateFormet(result[i]['time'])){
								str +="<div id='pdate'>"+xdate+"</div>";
								xdate=dateFormet(result[i]['time']);
							}
							if (result[i]['from']==null){
								if(result[i]['status']==true){
									var icon="<i class='fa fa-check seen'></i>";
								}else{
									var icon="<i class='fa fa-check unseen'></i>";
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
				if(is_loadNew){
                    is_loadNew = false;
					var sql='SELECT * FROM `user_message_'+id+'` AS a WHERE a.from="'+to_person+'" and a.status=false ORDER BY a.id DESC; UPDATE `user_message_'+id+'` SET status=true WHERE user_message_'+id+'.from="'+to_person+'";UPDATE `user_message_'+to_person+'` SET status=true WHERE user_message_'+to_person+'.to="'+id+'";';
                    $.ajax({url:"load_msg_ajax.php",data: {sql:sql},success:function(result){
						var str=''
						var result=JSON.parse(result);
						if(result.length > 0){
							for(let i = 0; i < result.length; i++){ 
								var time=c_time(result[i]['time']);
								str='';
								str +="<div id='msg_box'><div><i id='time'>"+time+"</i> <br><div id='msg'>"+result[i]['content']+"</div></div></div>";
							}
							$("#feedback").html(str+document.getElementById('feedback').innerHTML);
						}
                        
                    },complete:function(){
                        is_loadNew = true;
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
				str ="<div id='msg_box'><div><i id='mytime'>"+c_time()+"</i> <br><div id='mymsg'>"+message+"</div></div><i class='fa fa-check unseen'></i></div>";
				$("#feedback").html(str+document.getElementById('feedback').innerHTML);			
			}
		</script>
		<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
	</body>

</html>