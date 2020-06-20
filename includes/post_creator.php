<?php
    abstract class Post{
        public $detail_arr;
        public $author;
        public $author_link;

        public function __construct($detail_arr){
            $this->detail_arr = $detail_arr;
        }
        
        public function log_on_screen(){
            echo    "<div class='posts'>
                        <input type='hidden' class='post_index' value='".$this->detail_arr['post_index']."'>
                        <div class='post_title'>
                            <div class='author'>
                                <a class='post_a' href='".$this->author_link."'>"
                                    . $this->author .
                                "</a>";
                                if(!$this->detail_arr['tag']==''){
                                    echo " <i class='fa fa-toggle-right'></i> ".$this->detail_arr['tag'];
                                }
                                echo "</div>" . "<div class='post_date'> Date: {$this->detail_arr['date']}</div>";
                        echo"</div>";
                        echo"<div class='post_content'>" . $this->detail_arr['content'] . "</div>";
                        if(!$this->detail_arr['img']==''){
                            echo "<div class=post_image_container><img class=post_image src='".$this->detail_arr['img']."'/></div>";
                        }
                        $likes = array_filter(explode(" ",$this->detail_arr['likes']));
            echo        "<div class='like_bar'>
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
            echo                "</button>
                                <button onclick='show_comment(this)'>
                                    <i class='far fa-comment-alt'></i> "
                                    . $this->detail_arr['comments'] . " comments
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
            echo    "</div>";
        }
    }

    class Individual_post extends Post{

        public function __construct($detail_arr){
            parent::__construct($detail_arr);
            $this->author = $detail_arr['first_name']. " ".$detail_arr['last_name'];
            $this->author_link = "/view_profile.php?id=".$detail_arr['author'];
        }
    }

    class Organization_post extends Post{
        
        public function __construct($detail_arr){
            parent::__construct($detail_arr);
            $this->author = $detail_arr['org_name'];
            $this->author_link = "/organization?selected_org=".$detail_arr['org'];
        }
    }

    class Fundraising_post extends Post{
        
        public function __construct($detail_arr){
            parent::__construct($detail_arr);
            $this->author = $detail_arr['name'];
            $this->author_link = "/fundraising/view_fundraising.php?view_fun=".$detail_arr['fund'];
        }
    }

    class PostFactory{
        public function getPost($result_arr){
            if($result_arr['type'] == null){
                return null;
            }elseif($result_arr['type'] == "individual"){
                return new Individual_post($result_arr);
            }elseif($result_arr['type'] == "organization"){
                return new Organization_post($result_arr);
            }elseif($result_arr['type'] == "fundraising"){
                return new Fundraising_post($result_arr);
            }
        }
    }