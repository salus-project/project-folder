<?php
    ob_start();
    require $_SERVER['DOCUMENT_ROOT'] .'/confi.php';
    //require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";


    if(isset($_POST['upload'])){

        $img_name = "";

        if(isset($_FILES['upload_file']) && $_FILES['upload_file']['size']>0){
            $txt_file = "next_img_name.txt";
            $img_name = file_get_contents($txt_file);
            $writeVal = (string)((int)$img_name+1);
            file_put_contents($txt_file,$writeVal);

            $target_file = $img_name . ".jpg";
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

        $id = htmlspecialchars(stripslashes(trim($_POST['fund_id'])));

        
        $sql = "update fundraisings set img = IF(ISNULL((SELECT img)),'$img_name', concat((SELECT img), ',$img_name')) where id=$id";
        echo $sql;

        if (!mysqli_query($con,$sql)) {
            echo "Your post is not inserted<br>";
            echo $sql;
        } else {
            echo "<h2>Posted</h2>";
            header("location:".$_SERVER['HTTP_REFERER']);
            
        }
    }elseif(isset($_POST['delete'])){
        $img = $_POST['img'];
        $fund_id = $_POST['fund_id'];

        unlink($img.'.jpg');

        $query = 'update fundraisings set img = REPLACE(REPLACE(REPLACE((SELECT img), ",'.$img.'", ""), "'.$img.',", ""), "'.$img.'", "") where id='.$fund_id.';';
        if (!mysqli_query($con,$query)) {
            echo "Your post is not inserted<br>";
            echo $query;
        } else {
            echo "<h2>Posted</h2>";
            echo $query;
            header("location:".$_SERVER['HTTP_REFERER']);    
        }
    }
    //ob_end_flush();
?>