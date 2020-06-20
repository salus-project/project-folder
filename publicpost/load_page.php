<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    require $_SERVER['DOCUMENT_ROOT']."/includes/post_creator.php";
    $post_factory = new PostFactory();
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $query='select civilian_detail.first_name, civilian_detail.last_name, organizations.org_name, fundraisings.name, public_posts.* from (((public_posts LEFT JOIN civilian_detail on public_posts.author = civilian_detail.NIC_num) LEFT JOIN organizations on public_posts.org = organizations.org_id)  LEFT JOIN fundraisings on public_posts.fund = fundraisings.id) ORDER BY post_index DESC limit '.$_POST['from'].', 5';
        $result=$con->query($query);
        while($row=$result->fetch_assoc()){
            $post_factory->getPost($row)->log_on_screen();
        }
    }
?>