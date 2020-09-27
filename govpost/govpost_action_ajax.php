<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    session_start();

    if(isset($_POST['like'])){
        $query="select likes from goveposts where post_index='".$_POST['post_index']."'";
        $result=array_filter(explode(" ",$con->query($query)->fetch_assoc()['likes']));
        array_push($result,$_SESSION['user_nic']);
        $result_str = join(" ",$result);
        $query = "update goveposts set likes = '$result_str' where post_index = '".$_POST['post_index']."'";
        $result=$con->query($query);
        if($result){
            echo "true";
        }
        else{
            echo "false";
        }
    }
    if(isset($_POST['unlike'])){
        $query="select likes from goveposts where post_index='".$_POST['post_index']."'";
        $result=array_filter(explode(" ",$con->query($query)->fetch_assoc()['likes']));
        $result = array_diff($result,array($_SESSION['user_nic']));
        $result_str = join(" ",$result);
        $query = "update goveposts set likes = '$result_str' where post_index = '".$_POST['post_index']."'";
        $result=$con->query($query);
        if($result){
            echo "true";
        }
        else{
            echo "false";
        }
    }
    if(isset($_POST['view_cmt'])){
        $query="select civilian_detail.first_name,civilian_detail.last_name, govepost_comments.* from govepost_comments left join civilian_detail on civilian_detail.NIC_num = govepost_comments.author where govepost_comments.post_index ='" . $_POST['post_index']."'";
        $result = $con->query($query);
        while($row = $result->fetch_assoc()){
            echo "<div class='comment_container'>
                    <div class='cmt_name'><b>"
                        . (($row['author']=='gov')?'Comment by Government':($row['first_name'] . " " . $row['last_name'])) . 
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
        $result=null;
        $date = date("Y-m-d");
        $time = date("h:i:s");
        $query = "insert into govepost_comments (`author`, `date`, `time`, `post_index`, `content`) values ('".$_POST['sender']."', '" . $date . "', '" . $time . "', " . $_POST['post_index'] . " , '" . $_POST['content'] . "');
                    update goveposts set comments=((select comments)+1) where post_index = " . $_POST['post_index'] . ";
                    select civilian_detail.first_name,civilian_detail.last_name, govepost_comments.* from govepost_comments left join civilian_detail on civilian_detail.NIC_num = govepost_comments.author where govepost_comments.post_index =" . $_POST['post_index'].";";
        $con->multi_query($query);
        while($con->next_result()){
            $result = $con->store_result();
            if(!$con->more_results()) break;
        }
        while($row = $result->fetch_assoc()){
            echo "<div class='comment_container'>
                    <div class='cmt_name'><b>"
                        . (($row['author']=='gov')?'Comment by Government':($row['first_name'] . " " . $row['last_name'])) . 
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