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
    <div id="content">
        <?php
            $query='select * from public_posts';
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