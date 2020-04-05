
<html>
<head>
    <title>New post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_codes/createpost.css">
</head>
<body>
    <?php include "header.php";
        require "public_nav.php";
    ?>

    <?php
        $author = $date = $content = "";
        $author_err = $date_err = $content_err = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST["author"])){
                $author_err = "NIC number is required";
            } else {
                $author = test_input($_POST["author"]);
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST["date"])){
                $date_err = "date is required";
            } else {
                $date = test_input($_POST["date"]);
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST["content"])){
                $content_err = "Fill the content";
            } else {
                $content = test_input($_POST["content"]);
            }
        }
        
          
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <h2 class="head1">NEW POST</h2>
    <h4 class="head3">All public can see this post</h4>
    <h4 class="head4">* Required</h4>
    <div class="div1">
        <form method="post" action="createpost_insert.php">
            <label for="nic">Author (NIC number)</label><br>
            <input type="text" id="nic" name="author" placeholder="Enter NIC number" value="<?php echo $author;?>" required>
            <span class="error">*<?php echo $author_err; ?></span><br><br>
            <label for="date">Date</label><br>
            <input type="date" id="" name="date" placeholder="yyyy-mm-dd" value="<?php echo $date;?>" required>
            <span class="error">* <?php echo $date_err; ?></span><br><br>
            <label for="content">Your post</label><br>
            <textarea cols="45" rows="8" id="content" name="content" placeholder="post here" value="<?php echo $content;?>" required></textarea>
            <span class="error">* <?php echo $content_err; ?></span><br><br>
            <input type="submit" id="submit" name="submit" value="POST">
        </form>

       
    </div>  
</body>
</html>