<?php
            $servername = "remotemysql.com";
            $username = "kfm2yvoF5R";
            $password = "4vkzHfeBh6";
            $dbname = "kfm2yvoF5R";

            // Create connection
            $conn = mysqli_connect($servername, $username, $password);
            // Check connection
            if (!$conn) {
                echo("Connection failed ");
            }
            if(!mysqli_select_db($conn,$dbname)){
                echo "Database not selected";
            }
            $author = $_POST["author"];
            $date = $_POST["date"];
            $content = $_POST["content"];

            $sql = "INSERT INTO public_posts (author, date, content) VALUES ('$author', '$date', '$content')";

            if (!mysqli_query($conn,$sql)) {
                echo "Your post is not inserted";
            } else {
                echo "<h2>Posted</h2>";
            }
            header("refresh:1; url=publicpost.php");
            
        ?>