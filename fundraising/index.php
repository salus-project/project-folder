<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Fundraising events</title>
        <link rel="stylesheet" href="/css_codes/fundraising.css">
    </head>
    <body>

    <script>
        btnPress(7);
    </script>

    <div id="title">
        Fundraising events
    </div>
		<?php
		echo"<div id='boxes'>";
		echo"<h2 style='margin-left: 20px;'>Your fundraising programs</h2>";
			$id=$_SESSION['user_nic'];
			$query="select * from fundraisings where by_civilian='$id'";
			$result=$con->query($query);
			while($row=$result->fetch_assoc()){
				echo "<div id='boxA'>";
				echo"<h3 style='margin-left: 5px;'>".$row['name']."</h3>";
					echo "<form id=view_fund action=view_fundraising.php method=get>";
                        echo "<button class='btn_img_only' id=view_fun type='submit' name=view_fun value=".$row['id'].">view</button>";
                    echo "</form>";
					echo "</div>";

			}

				echo"<a href='create_fundraising.php'><button class='create_btn'>Create new fundraising event</button></a>";
		echo"</div>";

		echo"<div id='boxes'>";
		echo"<h2 style='margin-left: 20px;'>Other fundraising programs</h2>";
			$id=$_SESSION['user_nic'];
			$query="select * from fundraisings where by_civilian!='$id'";
			$result=$con->query($query);
			while($row=$result->fetch_assoc()){
				echo "<div id='boxB'>";
				echo"<h3 style='margin-left: 5px;'>".$row['name']."</h3>";
					echo "<form id=view_fund action=view_fundraising.php method=get>";
                        echo "<button class='btn_img_only' id=view_fun type='submit' name=view_fun value=".$row['id'].">view</button>";
                    echo "</form>";
					echo "<a id='donate_fund' href='/fundraising/donate?id=".$row['id']."'>";
                        echo "<button class='btn_img' id=donate_fun type='submit' name=donate_fun value=".$row['id'].">donate</button>";
                    echo "</a>";
					echo "</div>";

			}
		echo"</div>";
		?>
    </body>
</html>