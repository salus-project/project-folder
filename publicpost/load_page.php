<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $query='select civilian_detail.first_name, civilian_detail.last_name, organizations.org_name, public_posts.* from ((public_posts LEFT JOIN civilian_detail on public_posts.author = civilian_detail.NIC_num) LEFT JOIN organizations on public_posts.org = organizations.org_id) ORDER BY post_index DESC limit '.$_POST['from'].', 5';
        $result=$con->query($query);
        while($row=$result->fetch_assoc()){
            echo "<div id='posts'>";
                echo "<input type='hidden' class='post_index' value='".$row['post_index']."'>";
                echo "<div id='post_title'>";
                    $author_nic=$row['author'];
                    if($author_nic!=$_SESSION['user_nic']){$author=(($con->query("select first_name, last_name from civilian_detail where NIC_num='$author_nic'"))->fetch_assoc());
                        $author=($row['first_name'] . $row['last_name']) ?: $row['org_name'];
                    }else{
                        $author="You";
                    }
                    echo "<div id='author'>" . $author . "</div>" . "<div id='post_date'> Date: " . $row['date'] . "</div>";
                echo "</div>";
                echo "<div id='post_content'>" . $row['content'] . "</div>";
                if(!$row['img']==''){
                    echo "<div id=post_image_container><img id=post_image src='".$row['img']."'/></div>";
                }
                $likes = array_filter(explode(" ",$row['likes']));
                echo    "<div class='like_bar'>
                            <span class='like_count'>
                                " . sizeof($likes) . " likes
                            </span>
                            <div class='like_buttons_container'>
                                <button class='like_button' ";
                                    if((in_array($_SESSION['user_nic'],$likes))){
                                        echo "onclick='unlike(this)'><i class='fas fa-thumbs-up'></i> liked";
                                    }else{
                                        echo "onclick='like(this)'><i class='far fa-thumbs-up'></i> like";
                                    }
                echo            "</button>
                                <button onclick='show_comment(this)'>
                                <i class='far fa-comment-alt'></i> "
                                    . $row['comments'] . " comments
                                </button>
                                <button>
                                    <i class='fa fa-share'></i> share
                                </button>
                            </div>
                        </div>
                        <div class='comment_box_container'>
                            <div class='comment_box'>
                            </div>
                            <div class='new_comment'>
                                <input type='text' class='comment_input' placeholder='Enter comment here'><span class='send_btn' onclick='comment(this)'>send</span>
                            </div>
                        </div>";
            echo "</div>";
        }
    }
?>