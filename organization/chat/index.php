<?php
ob_start();
ignore_user_abort();

    require $_SERVER['DOCUMENT_ROOT'].'/organization/view_org_header.php';
	$org_id= "org_".$_GET['org_id'];
	if($text_role  == 'visitor'){
		header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/organization/all_org.php"));
		ob_end_flush();
		ob_flush();
		flush();
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>chat</title>
        <link rel="stylesheet" href='/css_codes/chat_org.css'>
    </head>
    <body>
        <script>
            document.getE
            btnPress(6);
        </script>
	<div id="container">
	<h1>Group Disscussion</h1>
	
		<div id="feedback">
		</div>
		
		
		<input type="text" class="chat_input_tag" autocomplete="off" spellcheck="false" name="msg_b" id="msg_b" onkeypress="enterKey(event)" placeholder="Type massage here" />  
		<input type="hidden" name="name" id="name" value="<?php echo  $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>">
        <input type="hidden" name="id" id="id" value="<?php echo  $_SESSION['user_nic']; ?>"> 
		<input type="hidden" name="org_id" id="org_id" value="<?php echo  $org_id; ?>"> 
        
		<button id="post_btn" type="button">Send</button>
		
		
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>
            var is_success = true;
			var position=0;

			$(document).ready(function(){
				
			setInterval(loadchats,100);
			$("#post_btn").click(function(){
				post_msg();
			});
						
			});

			function post_msg(){
				var name=$("#name").val();
				var id=$("#id").val();
				var message=$("#msg_b").val();
				var org_id=$("#org_id").val();
                //console.log(name+' '+id+' '+message);
				$.post("post.php",{name:name,message:message,id:id,org_id:org_id},function(data)
				{
					
					$("#msg_b").val("");
				});
			}

			function enterKey(e){
				if(e.keyCode==13){
					post_msg();
				}
			}
			
			function loadchats()
			{
                if(is_success){
                    is_success = false;
					var org_id=$("#org_id").val();
                    $.ajax({url:"chat_msg.php",data: {org_id: org_id},success:function(result){
                        $("#feedback").html(result);
                        
                    },complete:function(){
                        is_success = true;
						var tdh=$("#feedback")[0].scrollHeight;
						var dh=$("#feedback").height();
						var sl=tdh-dh;
						
						if(position==0){
							position=sl;
							bottom(sl);
						}
						if(sl>position){
							var height = $("#feedback").scrollTop();
							if((height+100)>=position){
								position=sl;
								bottom(sl);
							}
						}
                    }
                    });
                }
				
				
				
			}
			function bottom(sl){
				$("#feedback").animate({scrollTop:sl},'500');
				
			}
		</script>
	<?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>

