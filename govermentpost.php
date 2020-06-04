<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Goverment posts</title>
        <link rel="stylesheet" href="css_codes/gove.css">
    </head>
    <body>

    <script>
        btnPress(2);
    </script>

    <div id="title">
        Goverment posts
    </div>
    <div id="content">
        <?php
            $query='select * from goveposts';
            $result=$con->query($query);
            while($row=$result->fetch_assoc()){
                echo "<div id='posts'>";
                    echo "<div id='post_date'> Date: " . $row['date'] . "</div>";
                    echo "<div id='post_content'>" . $row['content'] . "</div>";
                echo "</div>";
            }
        ?>
    </div>
    </body>
</html>