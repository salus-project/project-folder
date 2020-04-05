<?php
    session_start();
    require 'dbconfi/confi.php'
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Public posts</title>
        <link rel="stylesheet" href="css_codes/publ.css">
    </head>
    <body>
    <?php require "header.php" ?>

    <script>
        btnPress(3);
    </script>

    <div id="title">
        Public posts
        
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

            //header('location:publicpost.php');
        }
    ?>

    <div id="content">
        <?php
            $query='select * from public_posts ORDER BY post_index DESC';
            $result=$con->query($query);
            while($row=$result->fetch_assoc()){
                echo "<div id='posts'>";
                    echo "<div id='post_title'>";
                        $author_nic=$row['author'];
                        if($author_nic!=$_SESSION['user_nic']){
                            $author=(($con->query("select first_name, last_name from civilian_detail where NIC_num='$author_nic'"))->fetch_assoc());
                            $author=$author['first_name'] . $author['last_name'];
                        }else{
                            $author="You";
                        }
                        echo "<div id='author'>" . $author . "</div>" . "<div id='post_date'> Date: " . $row['date'] . "</div>";
                    echo "</div>";
                    echo "<div id='post_content'>" . $row['content'] . "</div>";
                echo "</div>";
            }
        ?>
    </div>
    </body>
</html>