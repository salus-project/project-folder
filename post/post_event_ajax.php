<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";

    if(isset($_POST['like'])){
        $query="select likes from public_posts where post_index='".$_POST['post_index']."'";
        $result=array_filter(explode(" ",$con->query($query)->fetch_assoc()['likes']));
        array_push($result,$_SESSION['user_nic']);
        $result_str = join(" ",$result);
        $query = "update public_posts set likes = '$result_str' where post_index = '".$_POST['post_index']."'";
        $result=$con->query($query);
        if($result){
            echo "true";
        }
        else{
            echo "false";
        }
    }
    if(isset($_POST['unlike'])){
        $query="select likes from public_posts where post_index='".$_POST['post_index']."'";
        $result=array_filter(explode(" ",$con->query($query)->fetch_assoc()['likes']));
        $result = array_diff($result,array($_SESSION['user_nic']));
        $result_str = join(" ",$result);
        $query = "update public_posts set likes = '$result_str' where post_index = '".$_POST['post_index']."'";
        $result=$con->query($query);
        if($result){
            echo "true";
        }
        else{
            echo "false";
        }
    }
    if(isset($_POST['view_cmt'])){
        $query="select civilian_detail.first_name,civilian_detail.last_name, public_post_comments.* from civilian_detail inner join public_post_comments on civilian_detail.NIC_num = public_post_comments.author where public_post_comments.post_index ='" . $_POST['post_index']."'";
        $result = $con->query($query);
        while($row = $result->fetch_assoc()){
            echo "<div class='comment_container'>
                    <div class='cmt_name'><b>"
                        . $row['first_name'] . " " . $row['last_name'] . 
                    "</b></div>
                    <div class='cmt_content'>"
                        .$row['content']."
                    </div>
                    <div class='cmt_time'>"
                        . $row['date'] . " " . $row['time'] ."
                    </div>                      
            </div>";
        }
    }
    if(isset($_POST['comment'])){
        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");
        $time = date("h:i:s");
        $query = "insert into public_post_comments (`author`, `date`, `time`, `post_index`, `content`) values ('".$_SESSION['user_nic'] . "', '" . $date . "', '" . $time . "', '" . $_POST['post_index'] . "' , '" . $_POST['content'] . "');
                update public_posts set comments=((select comments)+1) where post_index = " . $_POST['post_index'] . ";
                select civilian_detail.first_name,civilian_detail.last_name, public_post_comments.* from civilian_detail inner join public_post_comments on civilian_detail.NIC_num = public_post_comments.author where public_post_comments.post_index =" . $_POST['post_index'].";";
        $con->multi_query($query);
        while($con->next_result()){
            $result = $con->store_result();
            if(!$con->more_results()) break;
        }
        while($row = $result->fetch_assoc()){
            echo "<div class='comment_container'>
                    <div class='cmt_name'><b>"
                        . $row['first_name'] . " " . $row['last_name'] . 
                    "</b></div>
                    <div class='cmt_content'>"
                        .$row['content']."
                    </div>
                    <div class='cmt_time'>"
                        . $row['date'] . " " . $row['time'] ."
                    </div>                      
            </div>";
        }
        $result -> free_result();
    }
?>