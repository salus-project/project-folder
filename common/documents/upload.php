<?php
    ob_start();
    ignore_user_abort();
    if(isset($_FILES['upload_file'])){
        if(isset($_POST['filename'])){
            $filename = $_POST['filename'];
        }elseif(isset($_POST['txt_filename'])){
            $filename = file_get_contents($_POST['txt_filename']);
            $writeVal = (string)((int)$img_name+1);
            file_put_contents($_POST['txt_filename'],$writeVal);
        }

        $target_dir = $_POST['directory'];
        $full_file_name = $filename . ".jpg";
        $target_file = $target_dir . $full_file_name;
        
        
        if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
            echo "<img src='".$target_file.".jpg?n=1'>";
            if(isset($_POST['header'])){
                $size = ob_get_length();
                
                // header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
                // header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                // header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                // header("Cache-Control: post-check=0, pre-check=0", false);
                // header("Pragma: no-cache");

                header("Content-Encoding: none");
                header("Content-Length: {$size}");
                header("location:".$_SERVER['HTTP_REFERER']);
                header("Connection: close");

                ob_end_flush();
                ob_flush();
                flush();
            }
            if(isset($_POST['resize'])&&$_POST['resize']=='true'){
                require_once 'resize.php';
                $resize = new ResizeImage($target_file);
                $resize->resizeTo(50, 50, 'exact');
                $resize->saveImage($target_dir."resized/".$full_file_name);

                echo "success";
            }
        } else {
            echo "false";
        }
    }
?>