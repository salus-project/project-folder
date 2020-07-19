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
                        <div>  
                            <div class='post_title'>".
                                "<div class='profile_pic'>
                                        <img src='".$this->profile_url."' alt='pic'>
                                </div>
                                <div class='profile'>
                                    <div class='author'>
                                    <a class='post_a' href='".$this->author_link."'><b>"
                                        . $this->author .
                                    "</b></a>";
                                    if(!$this->detail_arr['tag']==''){
                                        echo " <i class='fa fa-toggle-right'></i> ".$this->detail_arr['tag'];
                                    }
                                    echo "</div>" . "<div class='post_date'> Date: {$this->detail_arr['date']}</div></div>";
                            echo"</div>
                        </div>";
                        echo"<div><div class='post_content'>" . $this->detail_arr['content'] . "</div></div>";
                        if(!$this->detail_arr['img']==''){
                            echo "<div class=post_image_container><img class=post_image src='".$this->detail_arr['img']."'/></div>";
                        }
                        $likes = array_filter(explode(" ",$this->detail_arr['likes']));
            echo        "<div class='like_bar'>
                            <div class='likes'>
                                <span class='like_count'>
                                    " . sizeof($likes) . " likes
                                </span>
                            </div>
                            <div class='buttons_container'>
                                <div class='button_div'>
                                    <button class='button_con  but_1_2' ";
                                        if((in_array($_SESSION['user_nic'],$likes))){
                                            echo "onclick='unlike(this)'><i class='fas fa-thumbs-up'></i><b> liked</b>";
                                        }else{
                                            echo "onclick='like(this)'><i class='far fa-thumbs-up'></i> <b>like</b>";
                                        }
                echo                "</button>
                                </div>
                                <div class='button_div'>
                                    <button class='button_con  but_1_2' onclick='show_comment(this)'>
                                        <i class='far fa-comment-alt'></i><b> "
                                        . $this->detail_arr['comments'] . " comments</b>
                                    </button>
                                </div>
                                <div class='button_div'>
                                    <button class='button_con  but_3'>
                                        <i class='fa fa-share'></i><b> share</b>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                        <div class='comment_box_container'>
                            <div class='comment_box'>
                            comment1<br>
                            comment2<br>
                            commemnt
                            </div>
                                <div class='new_comment'>
                                    <div class='comment_div'>
                                        <input type='text' class='comment_input' placeholder='Enter your comment..'>
                                    </div>
                                    <div class='tooltip send_icon' onclick='comment(this)'>
                                        <span class='send_btn'><i class='fa fa-send'></i></span>
                                        <span class='tooltiptext'>SEND</span>
                                    </div>
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
            $this->profile_url = "http://d-c-a.000webhostapp.com/Profiles/resized/".$detail_arr['author'].".jpg";
        }
    }

    class Organization_post extends Post{
        
        public function __construct($detail_arr){
            parent::__construct($detail_arr);
            $this->author = $detail_arr['org_name'];
            $this->author_link = "/organization?selected_org=".$detail_arr['org'];
            $this->profile_url = '';
        }
    }

    class Fundraising_post extends Post{
        
        public function __construct($detail_arr){
            parent::__construct($detail_arr);
            $this->author = $detail_arr['name'];
            $this->author_link = "/fundraising/view_fundraising.php?view_fun=".$detail_arr['fund'];
            $this->profile_url = '';
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