<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    
    if(!isset($_GET['selected_org'])){
        $_GET['selected_org']=$_GET['org_id'];
    }else{
        //require('all_org.php');
        //exit();
    }
    $org_id=$_GET['selected_org'];
    $query="select * from organizations where org_id=".$_GET['selected_org'].";
    select * from org_members where org_id=".$_GET['selected_org']." and NIC_num='".$_SESSION['user_nic']."';";

    $text_role='';
    $member_arr=$co_leader_arr=array();
    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        $org_detail= mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result1 = mysqli_store_result($con);
        if(mysqli_num_rows($result1)>0){
            $member_detail = mysqli_fetch_assoc($result1);
            if($member_detail['role']=='leader'){
                $text_role='leader';
            }elseif($member_detail['role']=='coleader'){
                $text_role='co-leader';
            }elseif($member_detail['role']=='member'){
                $text_role='member';
            }
        }else{
            $text_role='visitor';
        }
        mysqli_free_result($result1);
    }
    require 'view_org-strategy.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href='/css_codes/view_org_header.css'>
        <link rel="stylesheet" href='/css_codes/member_nav.css.css'>
    </head>
    <body>
        
        <script>
            btnPress(6);
        </script>
        <div class=org_title>
            <div id='org_cover'>
                <?php
                    $org_cover_path = "http://d-c-a.000webhostapp.com/Organization/Covers/" . $org_detail['org_id'] . ".jpg";
                ?>
                <img id="org_cover_photo" src="<?php echo $org_cover_path;?>" alt="Opps..." class="org_cover_pic">
                <div id='org_profile_edit'>
                    <div class="org_profile_container">
                        <?php
                            $org_profile_path = "http://d-c-a.000webhostapp.com/Organization/Profiles/" . $org_detail['org_id'] . ".jpg";
                        ?>
                        <img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_profile_pic">
                    </div>
                    <?php
                        $viewer->change_profile_option();
                    ?>
                </div>
            </div>
            <div id='org_gradient_div'>
                <div id='org_name_container'>
                    <span id='org_name'><?php echo $org_detail['org_name']; ?></span><br>
                    <span id=org_detail><?php echo $org_detail['discription'] ?></span>
                </div>
                <?php
                    $viewer->change_coverphoto_option();
                ?>
            </div>           
            <div id=title_sub>
                <?php
                    $viewer->show_membership_button();
                    $viewer->show_edit_button();
                ?>
            </div>
        </div>
        <div id=org_button_container>
            <div id=home_button_container>
                <a href='/organization?selected_org=<?php echo $_GET['selected_org'] ?>'>
                    <button id=home_btn>Home</button>
                </a>
            </div>
            <?php
                $viewer->show_title_button();
            ?>
        </div>
        <script>
            const selected_org = "<?php echo $_GET['selected_org'] ?>";
        </script>
        <script src='/js/view_org.js'></script>
        <div id='org_main_body'>
            <div id='org_side_nav'>
                <?php include($_SERVER['DOCUMENT_ROOT']."/organization/member_nav.php");?>
            </div>
            <div id='org_sub_body'>