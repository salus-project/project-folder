<?php
    session_start();
    require 'dbconfi/confi.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="css_codes/homePage.css">
        

    </head>

    <body>
        
        <?php require "header.php" ?>

        <script>
            btnPress(1);
        </script>

        <div class="photo">
            <div class="pic_cover">
                <img src="Profiles/<?php echo $_SESSION['user_nic'] . ".jpg";?>" alt=<?php echo $_SESSION['user_nic'] . ".jpg";?> class="profile_pic">
            </div>
        </div>

        <div class="edit_btn">  
            <a href='update_cd.php'><button>Edit info</button></a>
        </div>

        <div class="detail">
            <table style="width:100%">
                <tr>
                    <td><?php echo "Name" ?></td>
                    <td><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Gender" ?></td>
                    <td><?php echo $_SESSION['gender']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "District" ?></td>
                    <td><?php echo $_SESSION['district']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Occupation" ?></td>
                    <td><?php echo $_SESSION['Occupation']; ?></td>
                </tr>
                <tr>
                    <td><?php echo "Address" ?></td>
                    <td><?php echo $_SESSION['address']; ?></td>
                </tr>
            </table>
        </div>

        <div id=new_post>
            <form method=post action=publicpost.php>
                <textarea id=post_text_area name=post_text_area rows=3 cols=5></textarea>
                <button type=submit id=submit name=submit value=post>POST</button>
            </form>
        </div>
        <?php
            if(isset($_POST['submit'])){
                $content = htmlspecialchars(stripslashes(trim($_POST['post_text_area'])));
                $date = date('Y-m-d');
                $author = $_SESSION['user_nic'];

                $sql = "INSERT INTO public_posts (author, date, content) VALUES ('$author', '$date', '$content')";

                if (!mysqli_query($con,$sql)) {
                    echo "Your post is not inserted";
                } else {
                    echo "<h2>Posted</h2>";
                }

                header('location:publicpost.php');
            }
        ?>
        <div id="content">
			<?php
				$author=$_SESSION['user_nic'];

				$query="select * from public_posts  WHERE author='$author' ORDER BY post_index DESC";
				$result=$con->query($query);
				while($row=$result->fetch_assoc()){
					echo "<div id='posts'>";
						echo "<div id='post_title'>";

							echo  "<div id='post_date'> Date: " . $row['date'] . "</div>";
						echo "</div>";
						echo "<div id='post_content'>" . $row['content'] . "</div>";
					echo "</div>";
				}
			?>
		</div> 

    </body>

</html>