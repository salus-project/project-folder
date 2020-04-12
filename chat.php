<?php
    session_start();
    require 'dbconfi/confi.php';
   
?>

<!DOCTYPE html>
<html>
    <head>
        <title>chat</title>
        <link rel="stylesheet" href='css_codes/chat_org.css'>
    </head>
    <body>
        <?php require 'header.php' ?>
        <script>
            btnPress(6);
        </script>
	<div id="container">
	<h1>Group Disscussion</h1>
		<div id="feedback">
		--
		</div>
		
		<form name=chat_form autocomplete="off">
		<input type="text" name="msg_b" id="msg_b" placeholder="type massage here">   
		<input type="hidden" name="name" id="name" value="<?php echo  $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>">
        <input type="hidden" name="id" id="id" value="<?php echo  $_SESSION['user_nic']; ?>">            
        
		<button id="post_btn" type="button">Send</button>
		<span id="status">-</span>
		
		</form>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				$("#msg_b").keypress(function()
				{
					$("#status").html("Typing Message...");
				});
			setInterval(function(){loadchats()},100);
			$("#post_btn").click(function(){
				var name=$("#name").val();
				var id=$("#id").val();
				var message=$("#msg_b").val();
				$.post("post.php",{name:name,message:message,id:id},function(data)
				{
					$("#status").html(data);
					$("#msg_b").val("");
				});
			});
						
			});
			
			function loadchats()
			{
				$.ajax({url:"chat_msg.php",success:function(result){
					$("#feedback").html(result);
				}});
			}
			</script>
	</body>

</html>