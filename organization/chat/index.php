<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
	$org_id= "org_".$_GET['chat'];
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
		
		<form name=chat_form autocomplete="off">
		<textarea rows="1" name="msg_b" id="msg_b" placeholder="type massage here"></textarea>   
		<input type="hidden" name="name" id="name" value="<?php echo  $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>">
        <input type="hidden" name="id" id="id" value="<?php echo  $_SESSION['user_nic']; ?>"> 
		<input type="hidden" name="org_id" id="org_id" value="<?php echo  $org_id; ?>"> 
        
		<button id="post_btn" type="button">Send</button>
		<span id="status">-</span>
		
		</form>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>
            var is_success = true;
			var position=0;

			$(document).ready(function(){
				$("#msg_b").keypress(function()
				{
					$("#status").html("Typing Message...");
				});
			setInterval(loadchats,100);
			$("#post_btn").click(function(){
				var name=$("#name").val();
				var id=$("#id").val();
				var message=$("#msg_b").val();
				var org_id=$("#org_id").val();
                //console.log(name+' '+id+' '+message);
				$.post("post.php",{name:name,message:message,id:id,org_id:org_id},function(data)
				{
					$("#status").html(data);
					$("#msg_b").val("");
				});
			});
						
			});
			
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
	</body>

</html>