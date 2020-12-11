<?php
    ob_start();
    session_start();
    //require 'confi.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";


    if(isset($_POST['post'])){

        $target_file = "NULL";
        $img = "";

        if(isset($_FILES['upload_file']) && $_FILES['upload_file']['size']>0){
            $txt_file = $_SERVER['DOCUMENT_ROOT'] . "/common/documents/gov_posts/next_img_name.txt";
            $img_name = file_get_contents($txt_file);
            $writeVal = (string)((int)$img_name+1);
            file_put_contents($txt_file,$writeVal);

            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/common/documents/gov_posts/";
            $target_file = $target_dir . $img_name . ".jpg";
            $img = $img_name;
            echo "target file - ". $target_file . "</br>";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            
            $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".<br>";
                $uploadOk = 1;
            } else {
                echo "File is not an image.</br>";
                $uploadOk = 0;
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.<br>";
                $uploadOk = 0;
            }
            // Check file size
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<h1>Sorry, your file was not uploaded.</h1><br>";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
                    echo "<h1>The file ". basename( $_FILES["upload_file"]["name"]). " has been uploaded.</h1>";
                } else {
                    echo "<h1>Sorry, there was an error uploading your file.<h1>";
                }
            }
        }

        $heading = htmlspecialchars(stripslashes(trim($_POST['heading'])));
        $content = htmlspecialchars(stripslashes(trim($_POST['content'])));
        $date = date('Y-m-d');
        $event = $_POST['event']?$_POST['event']:'NULL';
        
        $sql = "INSERT INTO `goveposts`(`date`, `heading`, `content`, `event`, `img`) VALUES ('$date', '$heading', '$content', $event, '$img')";

        if (!mysqli_query($con,$sql)) {
            echo "Your post is not inserted<br>";
        } else {
            echo "<h2>Posted</h2>";
            header("location:".$_SERVER['HTTP_REFERER']);
            
        }
    }elseif(isset($_POST['update'])){
        $post_index = $_POST['post_index'];
        $heading = htmlspecialchars(stripslashes(trim($_POST['heading'])));
        $content = htmlspecialchars(stripslashes(trim($_POST['content'])));
        $event = $_POST['event']?$_POST['event']:'NULL';

        $sql = "UPDATE goveposts set heading = '".$heading."', content = '".$content."', event = ".$event." where post_index = ".$post_index.";";
        mysqli_query($con,$sql);
        header("location:".$_SERVER['HTTP_REFERER']);
    }elseif(isset($_POST['delete'])){
        $post_index = $_POST['post_index'];

        $sql = "DELETE from goveposts where post_index = ".$post_index.";";
        mysqli_query($con,$sql);
        header("location:".$_SERVER['HTTP_REFERER']);
    }
?>