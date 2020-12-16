<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

	<title>Fundraising events</title>
	<link rel="stylesheet" href="/css_codes/fundraising.css">
	
    <script>
        btnPress(7);
    </script>
	<div id="event_box">
		<div id='program'>
			<div id='program_title'>Fundraising events</div>
		</div>
		<div>
			<form action=view_my_promises.php method=get>
				<button class='btn_prom'  type='submit'>My promises</button>
			</form>
		</div>
	</div>
		<?php
		echo"<div id='boxes'>";
		echo "<div id='program'>";
			echo"<div id='program_title'>Your fundraising programs</div>";
		echo "</div>";
			$id=$_SESSION['user_nic'];
			$query="select * from fundraisings where by_civilian='$id'";
			$result=$con->query($query);
			while($row=$result->fetch_assoc()){
				$imgs = array_filter(explode(',', $row['img']));
			echo '<div id="boxA">
					<div class="sub_slide_show">';
						if(count($imgs)>0){
							echo '<div class="slideshow-container">';		
							foreach ($imgs as $img) {
								echo '<div class="mySlides fade">
									<img class="slide_show_img" src="/common/documents/Fundraising/secondary/'.$img.'.jpg" style="width:100%;">
								</div>';
							}
							echo '</div>';
						}else{
						echo '<div style="width:100%;">
							<img style="width:100%;" src="/common/documents/Covers/default.jpg">
						</div>';
						}					
					echo'</div>';
                    echo "<div class='fund_detail'>";
                        echo "<div><img src='/common/documents/Fundraising/resized/".$row['id'].".jpg'></div>";
						echo"<h3 style='margin-left: 75px;color:white;'>".$row['name']."</h3>";
						echo "<div>";
							echo "<form class=view_fund action=view_fundraising.php method=get>";
								echo "<button class='btn_img_only' class=view_fun type='submit' name=view_fun value=".$row['id'].">view</button>";
							echo "</form>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
			echo "<div id='create_box'>
					<a href='create_fundraising.php'><button class='create_btn'>Create new fundraising event</button></a>
				</div>";
		echo"</div>";
			
		
		echo"<div id='boxes'>";
			echo"<div id='program'>
					<div id='program_title'>Other fundraising programs</div>
				</div>";
			$id=$_SESSION['user_nic'];
			$query="select * from fundraisings where by_civilian!='$id'";
			$result=$con->query($query);
			while($row=$result->fetch_assoc()){
				$imgs = array_filter(explode(',', $row['img']));

				echo "<div id='boxB'>";
				echo '<div class="sub_slide_show">';
					if(count($imgs)>0){
						echo '<div class="slideshow-container">';
						foreach ($imgs as $img) {
							echo '<div class="mySlides fade">
								<img class="slide_show_img" src="/common/documents/Fundraising/secondary/'.$img.'.jpg" style="width:100%;">
							</div>';
						}
						echo '</div>';
					}else{
					echo '<div style="width:100%;">
						<img style="width:100%;" src="/common/documents/Covers/default.jpg">
					</div>';
					}						
				echo '</div>';
			
                echo "<div class='fund_detail'>";
                    echo "<div><img src='/common/documents/Fundraising/resized/".$row['id'].".jpg'></div>";
					echo"<h3 style='margin-left: 75px;color:white;'>".$row['name']."</h3>";
					echo "<div>";
						echo "<form class=view_fund action=view_fundraising.php method=get>";
							echo "<button class='btn_img_only' class=view_fun type='submit' name=view_fun value=".$row['id'].">view</button>";
						echo "</form>";
					echo "</div>";
					echo "<div>";
						echo "<a id='donate_fund' href='/fundraising/donate?id=".$row['id']."'>";
							echo "<button class='btn_img' id=donate_fun type='submit' name=donate_fun value=".$row['id'].">donate</button>";
						echo "</a>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
			}
		echo"</div>";
		?>
		
	<script>
		var slideshow = document.getElementsByClassName("slideshow-container"); // Do not use a period here!
		var j;
		for (j = 0; j < slideshow.length; j++) {
			al_show_slide(slideshow[j]);
		}	
		function al_show_slide(element){	
			var slideIndex = 0;	
			function showSlides() {			
				var i;
				var slides = element.getElementsByClassName("mySlides");
				console.log(slides.length);
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";  
				}
				slideIndex++;
				if (slideIndex > slides.length) {slideIndex = 1}
				slides[slideIndex-1].style.display = "block";
				setTimeout(showSlides, 4000); 
			}			
			showSlides();
		}
	</script>
    <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
