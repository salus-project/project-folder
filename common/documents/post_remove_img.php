<?php
    ob_start();
    session_start();
    //require 'confi.php';
    require_once $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";


    if(isset($_POST['remove'])){
        $file = $_POST['file'];
        $post_id = $_POST['post_id'];

        unlink($_SERVER['DOCUMENT_ROOT'] . "/common/documents/public_posts/".$file);
        
        $sql = "UPDATE `public_posts` SET `img`='' where `post_index` = ".$post_id.";";

        if (!mysqli_query($con,$sql)) {
            echo "Your post is not removed<br>";
            echo $sql;
        } else {
            echo "<h2>Posted</h2>";
            header("location:".$_SERVER['HTTP_REFERER']);
            
        }
    }
    ob_end_flush();
?>